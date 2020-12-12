<?php


namespace App\maguttiCms\Api\V1\Controllers;


use App\maguttiCms\Tools\ErrorCodes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\maguttiCms\Tools\JsonApiResponseTrait;

class UserController extends BaseApiController
{
    use JsonApiResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:gf_api', ['except' => ['login', 'create']]);
    }


    public function create(Request $request)
    {

        $input = $request->only('name','email','password');

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $errorCode = $this->encodeError($validator->failed());
            return $this->addValidationError(
                $errorCode['code'],
                $errorCode['description'],
                '',
                $validator->getMessageBag())
                ->responseWithValidationError();

        }
        return $data =  DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) {

            });
        });
    }

    public function user(Request $request)
    {
        $user = Auth::guard()->user();
        return new UserResource($user);
    }

    // revoca del token
    public function logout(Request $request)
    {
        $token = Auth::user()->token();
        $token->revoke();
        return $this->responseSuccess()->apiResponse();
    }

    // Update user date
    public function update(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = $this->parserApiDataAsArray($request);
        $validator = Validator::make($data['attributes'], $this->validationRules($user->id));

        if ($validator->failed()) {
            $failedRules = $validator->failed();
            $errorCode = $this->encodeError($failedRules);
            return $this->addValidationError(
                $errorCode['code'],
                $errorCode['description'],
                '',
                $failedRules)
                ->responseWithValidationError();

        }
        $user = (new UpdateUserFromApiAction())->handle($user, $data['attributes']);
        if (is_object($user)) {
            return new UserResource($user);
        }
        return $this->responseWithInvalidData();
    }

    public function update_password(Request $request)
    {
        $user = Auth::guard('api')->user();
        $data = $this->parserApiDataAsArray($request);

        $validator = $this->dataValidator('user_update_password', $data);   

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            $errorCode = $this->encodeError($failedRules);
            return $this->addValidationError(
                $errorCode['code'],
                $errorCode['description'],
                '',
                $failedRules)->responseWithValidationError();
        }

        if (!Hash::check(data_get($data['attributes'], 'old_password', 'xxx'), $user->password)) {
            return $this->addValidationError(ErrorCodes::WrongOldPassword, 'wrong_old_password')->responseWithValidationError();
        }
        $user = (new UpdateUserFromApiAction())->handle($user, $data['attributes']);
        return $this->responseSuccess()->apiResponse();
    }


    public function validationRules($user_id = '')
    {
        $user_id_vaidation = ',' . $user_id;
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'company' => 'required|string',
            'email' => 'required|Between:3,64|email|unique:xxgf_user,email' . $user_id_vaidation,
            'id_country' => 'required|max:2',
            'state' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'address_number' => 'required',
            'zip_code' => 'required',
            'area_code' => 'required',
            'telephone' => 'required',
            'lang' => 'required|max:2',
            'password' => 'sometimes|required|string|min:6',
            'is_private' => 'required'
        ];
    }

    function encodeData($user)
    {
        $encoder = Encoder::instance([
            User::class => \App\JsonApi\Users\Schema::class,
        ]);
        return $encoder->serializeData($user);
    }

    function encodeError($failedRules)
    {
        if (data_get($failedRules, 'email')) {
            if (data_get($failedRules['email'], 'Unique')) return $errorCode = ['code' => ErrorCodes::EmailAlreadyUsed, 'description' => 'email_already_used'];
            if (isset($failedRules['email']['Email'])) return $errorCode = ['code' => ErrorCodes::EmailInvalidFormat, 'description' => 'email_invalid_format'];
        }
        if (isset($failedRules['password'])) return $errorCode = ['code' => ErrorCodes::PasswordInvalidFormat, 'description' => 'invalid_password_format'];
        return ['code' => ErrorCodes::InvalidParameters, 'description' => 'invalid_parameters'];
    }
}