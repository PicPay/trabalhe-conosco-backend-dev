<?php
    namespace kaizer666\LaravelUnionPaginator\Test;
    use Illuminate\Database\Schema\Blueprint;
    use Orchestra\Testbench\TestCase as OrchestraTestCase;
    abstract class TestCase extends OrchestraTestCase
    {
        public function setUp()
        {
            parent::setUp();
            $this->setUpDatabase();
            $this->seedDatabase();
            
        }
        public function getEnvironmentSetUp($app)
        {
            $app['config']->set('database.default', 'mysql');
            $app['config']->set('database.connections.mysql', [
                'driver' => 'mysql',
                'database' => 'test',
                'prefix' => '',
            ]);
            $app['config']->set('app.key', '6rE9Nz372GRbeMATftriyQjrpF7DcOQm');
        }
        protected function setUpDatabase()
        {
            $this->resetDatabase();
            $this->createTables();
        }
        protected function resetDatabase()
        {
            $this->app['db']->connection()->getSchemaBuilder()->drop("users");
        }
        protected function createTables()
        {
            $this->createUsersTable();
        }
        protected function createUsersTable()
        {
            $this->app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string("login");
                $table->string("password");
                $table->timestamps();
            });
        }
        public function seedDatabase() {
            foreach ($i=1; $i<=104; $i++) {
                $this->app['db']->connection()->getSchemaBuilder()->table('users')
                    ->insert([
                            "login" => "login" . $i,
                            "password" => "123456",
                        ]);
            }
        }
    }