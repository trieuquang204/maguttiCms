<?php namespace App\maguttiCms\Website\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\maguttiCms\Website\Repos\Article\ArticleRepositoryInterface;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Override Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $redirectTo   = '/users/dashboard';
    protected $redirectPath = '/users/dashboard';
    public $localePrefix;
    use \App\maguttiCms\SeoTools\MaguttiCmsSeoTrait;
    protected $articleRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ArticleRepositoryInterface $article)
    {
        $this->middleware('guest');
        $this->localePrefix    = get_locale();
        $this->redirectTo      = $this->localePrefix.'/users/dashboard';
        $this->redirectPath    = $this->localePrefix.'/users/dashboard';
        $this->articleRepo = $article;
    }

    public function showResetForm(Request $request, $token = null)
    {
        $article = $this->articleRepo->getBySlug('home');
        $this->setSeo($article);
        \SEO::setTitle(trans(trans('message.password_reset')));

        return view('website.auth.reset')->with(
            ['token' => $token, 'email' => $request->email,'article'=>$article]
        );
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($response=='passwords.user') {
            $response="passwords.invalid";
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:10|regex:'.config('maguttiCms.security.password_regex'),
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }
}
