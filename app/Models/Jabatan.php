<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
	protected $table = 'jabatan';

    protected $primaryKey = 'id_jabatan';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['nama_jabatan','status_jabatan'];
}