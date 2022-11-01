<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
      protected $table = 'sucursales';
      public $timestamps = false;
  
      protected $fillable = [
          'idsucursal', 'telefono', 'direccion', 'linkmapa',
      ];
  
      protected $hidden = [
  
      ];

      public function insertar()
      {
          $sql = "INSERT INTO $this->table(
                  telefono,
                  direccion,
                  linkmapa
              ) VALUES (?, ?, ?);";
          $result = DB::insert($sql, [
              $this->telefono,
              $this->direccion,
              $this->linkmapa
          ]);
          return $this->idsucursal = DB::getPdo()->lastInsertId();
      }
}