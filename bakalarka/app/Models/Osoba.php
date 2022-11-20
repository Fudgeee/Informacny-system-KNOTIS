<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Osoba extends Model
{
	use HasFactory;
	protected $table = 'osoba';
	public $timestamps = false;

	// private $database;
	// public function getServers(int $is_server)
	// {
	// 	return $this->database->table('server')->where('ID_user',$userId);
	// }
}
