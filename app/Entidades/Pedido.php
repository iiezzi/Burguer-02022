<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
      protected $table = 'pedidos';
      public $timestamps = false;
  
      protected $fillable = [
          'idpedido', 'fecha', 'descripcion', 'total', 'fk_idsucursal', 'fk_idcliente', 'fk_idestado',
      ];
  
      protected $hidden = [
  
      ];

      public function insertar()
      {
          $sql = "INSERT INTO $this->table(
                  fecha,
                  descripcion,
                  total,
                  fk_idsucursal,
                  fk_idcliente,
                  fk_idestado
              ) VALUES (?, ?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->fecha,
              $this->descripcion,
              $this->total,
              $this->fk_idsucursal,
              $this->fk_idcliente,
              $this->fk_idestado
          ]);
          return $this->idpedido = DB::getPdo()->lastInsertId();
      }
}