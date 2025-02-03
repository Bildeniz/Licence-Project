<?php
require 'vendor/autoload.php';
require 'db.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['username', 'lastLogin', 'email', 'password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
}


class Licence extends Model
{
    protected $table = 'licences';

    protected $fillable = ['name', 'active', 'limit_device', 'endDate'];
}

class Device extends Model
{
    protected $table = 'devices';

    protected $fillable = ['fingerprint', 'active'];
}
function create_tables()
{
    $schema = Capsule::schema();

    if (!$schema->hasTable('users')) {
        $schema->create('users', function ($table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->dateTime('lastLogin')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
        });
    }

    if (!$schema->hasTable('licences')) {
        $schema->create('licences', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('limit_device');
            $table->date('endDate');
        });
    }

    if (!$schema->hasTable('devices')) {
        $schema->create('devices', function ($table) {
            $table->increments('id');
            $table->string('fingerprint')->unique();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('licence_id'); // Foreign key for Licences
            $table->foreign('licence_id')->references('id')->on('licences')->onDelete('cascade');
        });
    }}

create_tables();