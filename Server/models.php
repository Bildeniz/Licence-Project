<?php
require 'vendor/autoload.php';
require 'db.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Model
{
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = ['username', 'lastLogin', 'email', 'password'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
}


class Licence extends Model
{
    protected $table = 'licences';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['name', 'active', 'limit_device', 'end_date', 'uuid'];

    public function devices()
    {
        return $this->hasMany(Device::class, 'licence_id', 'id');
    }
}

class Device extends Model
{
    protected $table = 'devices';

    public $timestamps = false;

    protected $fillable = ['fingerprint', 'active', 'name'];

    public function licence()
    {
        return $this->belongsTo(Licence::class, 'licence_id', 'id');
    }
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

        User::create([
            'username' => 'admin',
            'password' => '123456789'
        ]);
    }

    if (!$schema->hasTable('licences')) {
        $schema->create('licences', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->uuid('uuid')->unique();
            $table->unsignedInteger('limit_device')->nullable();
            $table->date('end_date');
        });
    }

    if (!$schema->hasTable('devices')) {
        $schema->create('devices', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('fingerprint');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('licence_id'); // Foreign key for Licences
            $table->foreign('licence_id')->references('id')->on('licences')->onDelete('cascade');
        });
    }}

create_tables();