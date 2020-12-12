<?php

namespace App\Console\Commands\Support\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use App\Console\Commands\Support\Model\support\StubTypeResolver;

class CreateModel extends Command
{


    /**
     * Il nome e la signature del command.
     *
     * @var string
     */
    protected $signature = '
                            magutticms:create-model
                            {table : table name.}
                            {model? : model name.}
                            {--translatable=true : true if Model is translatable.}
                            {--sluggable=false : true if Model is sluggable.}
                            ';

    /**
     * La descrizione del command.
     *
     * @var string
     */
    protected $description = 'This  command create a model and the related admin form configuration field from given db table .';

    /**
     * I fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * I type Doctrine che non hanno un match diretto con i type dei fieldspec.
     * La chiave è il tipo proveniente dal DB, il valore è il tipo
     * corrispondente nel FieldSpec.
     *
     * @var array
     */
    protected $databaseTypeMappings = [
        'float'   => 'string',
        'decimal' => 'string',
        'bigint'  => 'integer'
    ];

    /**
     * Il model per cui è stato invocato il comando.
     *
     * @var string
     */
    protected $model = '';

    /**
     * Il Model stub che rappresenta il Model che verrà creato.
     *
     * @var string
     */
    protected $modelStub = '';

    /**
     * Il placeholder per le linee da rimuovere.
     *
     * @var string
     */
    protected $dropLine = '[dropline]';

    /**
     * I campi da considerare non fillable di default.
     *
     * @var array
     */
    protected $ignoreFillable = ['id', 'created_at', 'updated_at','created_by','updated_by'];

    /**
     * I campi da considerare translatable di default.
     *
     * @var array
     */
    protected $defaultTranslatable = ['title', 'name', 'description'];

    /**
     * I suffissi che identificano i possibili campi translatable.
     *
     * @var array
     */
    protected $translatableSuffixes = ['it', 'en', 'ru', 'de', 'es', 'fr'];

    /**
     * I campi da considerare sluggable di default.
     *
     * @var array
     */
    protected $defaultSluggable = ['title', 'name'];

    /**
     * I campi da non mettere nei FieldSpec di default.
     *
     * @var array
     */
    protected $ignoreFieldSpec = ['created_at', 'updated_at','created_by','updated_by'];

    protected $defaultMediaField = ['image', 'doc'];

    /**
     * Crea una nuova istanza di command.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->modelStub = file_get_contents(__DIR__ . '/stubs/model.stub');
    }

    /**
     * Esegui il console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $table = $this->argument('table');
        $this->model = ucfirst($this->argument('model'));
        $translatable = ($this->option('translatable') == 'true');
        $sluggable = ($this->option('sluggable') == 'true');

        // Se non viene fornito un nome per il Model tenta di ipotizzarne uno in automatico.
        if ($this->model === '' && !$this->isGuessedModelCorrect($table))
            return;

        // Istanzia Doctrine SchemaBuilder.
        $schemaBuilder = DB::getSchemaBuilder();

        echo "Reading [$table] table" . PHP_EOL;

        // Loop di tutte le colonne per ottenere il type e calcolare i possibili translatable.
        $translatableFields = [];
        foreach ($schemaBuilder->getColumnListing($table) as $column) {

            $type = $schemaBuilder->getColumnType($table, $column);
            echo "Column name: [$column] => [$type]" . PHP_EOL;

            $this->fields[$column] = [
                'type'         => $type,
                'translatable' => $this->isTranslatable($column),
                'relation'     => $this->isRelation($column)
            ];
        }

        // Compile the nodel staub.
        $this->setTranslatable();
        $this->setSluggable();
        $this->setFillable();
        $this->setFieldSpec();

        // Rimuovi le righe inutili.
        $this->dropLines();

        // Scrivi il Model.
        $this->writeModel();
    }

    /**
     * Questo metodo serve per aggiungere tutti i componenti translatable allo stub.
     */
    private function setTranslatable(): void
    {
        // Flat dei translatable fields;
        $this->flattenTranslatableFields();

        // Considera solo i fields che hanno 'translatable' impostato a true.
        $translatableFields = Arr::where($this->fields, function($value, $key) {
            return $value['translatable'] == true;
        });
        $translatableFields = $this->buildFormattedArrayValues(array_keys($translatableFields));

        // Leggi gli stub.
        $translatableNamespaces = ($translatableFields === '') ? $this->dropLine : file_get_contents(__DIR__ . '/stubs/translatable/translatable_namespaces.stub');
        $translatableTraits = ($translatableFields === '') ? $this->dropLine : file_get_contents(__DIR__ . '/stubs/translatable/translatable_traits.stub');
        $translatableEagerLoading = ($translatableFields === '') ? $this->dropLine : file_get_contents(__DIR__ . '/stubs/translatable/translatable_eager.stub');
        $translatableAttributes = ($translatableFields == '') ? $this->dropLine : str_replace('##translatable_fields##', $translatableFields, file_get_contents(__DIR__ . '/stubs/translatable/translatable_attributes.stub'));

        // Aggiungi i namespaces.
        $this->modelStub = str_replace('##translatable_namespaces##', $translatableNamespaces, $this->modelStub);

        // Aggiungi le Traits.
        $this->modelStub = str_replace('##translatable_traits##', $translatableTraits, $this->modelStub);

        // Aggiungi eager loading.
        $this->modelStub = str_replace('##translatable_eager##', $translatableEagerLoading, $this->modelStub);

        // Aggiungi i translatable attributes.
        $this->modelStub = str_replace('##translatable_attributes##', $translatableAttributes, $this->modelStub);

        if ($translatableFields != '')
            $this->writeTranslationModel();
    }

    /**
     * Questo metodo serve a rimuovere i possibili duplicati dai campi translatable.
     * Esempio: 'name_it', 'name_en', 'name_ru' divantano 'name'.
     */
    private function flattenTranslatableFields(): void
    {
        /*
         * Flat dei translatable fields.
         * Merge e unique delle chiavi multiple traducibili dell'array.
         *
         * Array originale: ['name_it' => [], 'name_en' => [], 'name_ru' => [], 'name_de' => [], 'name_es' => [], 'name_fr' => [], 'description' => []]
         * Obbiettivo: ['name' => [], 'description' => []]
         */
        $translatableFields = [];
        array_walk($this->fields, function($value, $key) use (&$translatableFields) {

            if ($this->isTranslatable($key)) {

                $bits = explode('_', $key);
                $key = implode('_', array_slice($bits, 0, max(1, count($bits) - 1)));
            }

            $translatableFields[$key] = $value;
        });

        // Aggiorna i fields con il nuovo array filtrato.
        $this->fields = $translatableFields;
    }

    /**
     * Questo metodo serve ad inserire gli sluggable nello stub.
     */
    private function setSluggable(): void
    {
        $sluggableFields = array_intersect(array_keys($this->fields), $this->defaultSluggable);

        // Set ci sono degli sluggable crea tutti gli stubs.
        $sluggableAttributes = empty($sluggableFields) ? $this->dropLine : file_get_contents(__DIR__ . '/stubs/sluggable/sluggable_attributes.stub');
        $stubs = [];
        if (!empty($sluggableFields)) {

            $sluggableFieldStub = trim(file_get_contents(__DIR__ . '/stubs/sluggable/sluggable_field.stub'));

            foreach ($sluggableFields as $field) {
                $stubs[] = str_replace('##sluggable_field_name##', $field, $sluggableFieldStub);
            }
        }

        // Aggiungi tutti gli sluggable allo stub principale.
        $stubs = implode(",\n        ", $stubs);
        $sluggableAttributes = str_replace('##sluggable_fields##', $stubs, $sluggableAttributes);

        $this->modelStub = str_replace('##sluggable##', $sluggableAttributes, $this->modelStub);
    }

    /**
     * Questo metodo serve ad inserire i fillable nello stub.
     */
    private function setFillable(): void
    {
        // Inizializza lo stub.
        $fillableAttributes = empty($this->fields) ? $this->dropLine : file_get_contents(__DIR__ . '/stubs/fillable/fillable_attributes.stub');

        // Rimuovi dai fillable quelli che vanno ignorati e crea la lista di fillable da inserire.
        $fillableFields = array_diff(array_keys($this->fields), $this->ignoreFillable);
        $fillableFields = $this->buildFormattedArrayValues($fillableFields);

        // Aggiungi i fillable.
        $fillableAttributes = str_replace('##fillable_fields##', $fillableFields, $fillableAttributes);
        $this->modelStub = str_replace('##fillable_attributes##', $fillableAttributes, $this->modelStub);
    }

    /**
     * This  method generate the FieldSpec nello stub.
     */
    private function setFieldSpec(): void
    {
        $fieldSpecStubs = [];
        $relationStubs = [];
        foreach ($this->fields as $field => $definition) {

            // Se il field è presente tra i FieldSpec da ignorare non proseguire.
            if (in_array($field, $this->ignoreFieldSpec))
                continue;

            // Cambia il type se è presente un override del tipo nei databaseTypeMappings.
            $type = $definition['relation'] ? 'relation' : Arr::get($this->databaseTypeMappings, $definition['type'], $definition['type']);

            // Se il type è integer ed il field si chiama 'id', usa il type 'primary_key'.
            $type = ($type === 'integer' && $field === 'id') ? 'primary_key' : $type;

            // get stub  file content.
            $stub = (new StubResolver())->getContent($type,$field);

            //  try to guess f relation ??? .
            if ($type === 'relation') {

                // Rimuovi il prefisso/suffisso 'id' e ipotizza un nome per il Model della relation.
                $relationTable = str_replace(['id_', '_id'], '', $field);
                $relationModel = $this->guessModelForTable($relationTable);

                // Per convenzione di Laravel i nomi delle relation sono formattati in camelCase al plurale.
                $relationName = Str::plural(Str::camel($relationModel));

                // Inserisci i valori nello stub del FieldSpec.
                $stub = str_replace('##relation_model##', $relationModel, $stub);
                $stub = str_replace('##relation_name##', $relationName, $stub);

                // Aggiungi la relation per il field.
                $stubName = $this->followsLaravelConvention($relationModel, $field) ? 'relation' : 'rich_relation';
                $relationStub = file_get_contents(__DIR__ . "/stubs/relations/$stubName.stub");

                // Inserisci i valori nello stub della relation.
                $relationStub = str_replace('##relation_name##', $relationName, $relationStub);
                $relationStub = str_replace('##relation_model##', $relationModel, $relationStub);
                $relationStub = str_replace('##relation_field##', $field, $relationStub);

                // Aggiungi la relation all'array di possibili relation per questo Model.
                $relationStubs[] = str_replace('##field##', $field, $relationStub);
            }

            // Sostituisci il field e aggiungi lo stub all'array di FieldSpec per questo Model..
            $fieldSpecStubs[] = str_replace('##field##', $field, $stub);
        }

        // Aggiungi i FieldSpec.
        $this->modelStub = str_replace('##fieldspecs##', implode("\n\n        ", $fieldSpecStubs), $this->modelStub);

        // Aggiungi i metodi per le relations.
        $this->modelStub = str_replace('##relations##', implode("\n\n        ", $relationStubs), $this->modelStub);
    }

    /**
     * Questo metodo serve a rimuovere le linee che contengono il placeholder dropLine dallo stub.
     * Rimuove anche tutte le linee vuote che non servono.
     */
    private function dropLines(): void
    {
        $this->modelStub = preg_replace('/^(\s)*\[dropline\]\n/m', '', $this->modelStub);

        //  Elimina linea vuota prima della dichiarazione della classe se presente.
        $this->modelStub = preg_replace('/^(\n\n)class /m', "\nclass ", $this->modelStub);

        // Elimina linea vuota tra la dichiarazione della classe e il primo statement se presente.
        $this->modelStub = preg_replace('/^(class [^ ]+ extends Model\n{\n)(\n)/m', "$1", $this->modelStub);

        // Sostituisci le doppie interlinee con un'interlinea singola.
        $this->modelStub = preg_replace('/\n\n$/m', "\n", $this->modelStub);

        // Sistema indentazione delle funzioni se per caso sono indentate troppo (succede per le relations).
        $this->modelStub = str_replace('        public function', '    public function', $this->modelStub);
    }

    /**
     * Questo metodo serve a creare il Model dallo stub.
     */
    private function writeModel(): void
    {
        $this->modelStub = str_replace('##model##', $this->model, $this->modelStub);
        $fileName = app_path("{$this->model}.php");

        echo "Create Model [{$this->model}]" . PHP_EOL;

        $this->writeFile($fileName, $this->modelStub);
    }

    /**
     * Questo metodo serve a creare il Model per i translatable.
     */
    private function writeTranslationModel(): void
    {
        echo "Crea translatable Model [{$this->model}Translation]" . PHP_EOL;
        $translationModel = str_replace('##model##', $this->model, file_get_contents(__DIR__ . '/stubs/translation_model.stub'));

        // Richiedi conferma e crea Model.
        $this->writeFile(app_path("{$this->model}Translation.php"), $translationModel);
    }

    /**
     *
     * @param $file
     * @param $content
     */
    private function writeFile($file, $content): void
    {
        // Controlla se il file esiste già e, nel caso, chiedere se proseguire con la sovrascrittura.
        if (file_exists($file)) {

            if (!$this->confirm('Model exists, overwritten?')) {
                echo "Model not created." . PHP_EOL;
                return;
            }
        }

        file_put_contents($file, $content);
    }

    /**
     * Questo metodo serve a formattare gli elementi di un array in modo da metterli tutti uno
     * sotto l'altro allineati, separati da virgola e con wrap tra apici.
     *
     * @param $values
     *
     * @return string
     */
    private function buildFormattedArrayValues($values): string
    {
        // Aggiungi wrap tra apici a tutti i nomi dei campi.
        $values = array_map(function($value) {
            return "'$value'";
        }, $values);

        // Gli spazi servono ad allineare con "doppio rientro".
        return implode(",\n        ", $values);
    }

    /**
     * Questo metodo serve ad ipotizzare un nome di Model se non viene fornito al command.
     * Alla fine del processo richiede anche conferma all'utente.
     *
     * @param $table: La tabella di riferimento nel DB
     *
     * @return bool
     */
    private function isGuessedModelCorrect($table): bool
    {
        $this->model = $this->guessModelForTable($table);
        return $this->confirm("Model '{$this->model}' seems to be already present, continue?");
    }

    /**
     * Questo metodo serve ad ipotizzare un nome di Model per una data tabella.
     *
     * @param $table: La tabella di riferimento
     *
     * @return string
     */
    private function guessModelForTable($table): string
    {
        return Str::studly(Str::singular($table));
    }

    /**
     * Questo metodo serve per capire se un field è un possibile translatable.
     *
     * @param $field: Il field da controllare
     *
     * @return bool
     */
    private function isTranslatable($field): bool
    {
        // Se il campo è contenuto nei defaultTranslatable non proseguire oltre.
        if (in_array($field, $this->defaultTranslatable)) {
            return true;
        }

        // I campi senza un '_' come delimitatore lingua non sono considerati per evitare
        // che campi come ad esempio 'en' vengano considerati translatable.
        $bits = explode('_', $field);
        if (count($bits) > 0) {
            if (in_array(end($bits), $this->translatableSuffixes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Questo metodo serve per capire se un field è una possibile relation.
     *
     * @param $field: Il field da controllare
     *
     * @return bool
     */
    private function isRelation($field): bool
    {
        // Se il campo ha come prefisso o suffisso 'id' con un underscore come separatore
        // il campo viene considerato una relation.
        return Str::startsWith($field, 'id_') || Str::endsWith($field, '_id');
    }

    /**
     * Questo metodo serve per capire se la foreign key definita in una tabella per una
     * relation rispetta la convenzione di Laravel oppure no.
     *
     * @param $relationModel
     * @param $field
     *
     * @return bool
     */
    private function followsLaravelConvention($relationModel, $field): bool
    {
        // Deduci la foreign key seguendo la convenzione di Laravel.
        $conventionalForeignKey = Str::snake($relationModel) . '_id';

        // Se la chiave ottenuta non corrisponde alla chiave fornita la relation non
        // segue la convenzione, quindi sarà necessario specificare la foreign key
        // al momento della definizione della relation.
        return $conventionalForeignKey === $field;
    }
}
