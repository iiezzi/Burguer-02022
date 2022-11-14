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

      public function obtenerPorId($idsucursal)
      {
          $sql = "SELECT
                  idsucursal,
                  telefono,
                  direccion,
                  linkmapa
                  FROM $this->table WHERE idsucursal = $idsucursal";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idsucursal = $lstRetorno[0]->idsucursal;
              $this->telefono = $lstRetorno[0]->telefono;
              $this->direccion = $lstRetorno[0]->direccion;
              $this->linkmapa = $lstRetorno[0]->linkmapa;
              return $this;
          }
          return null;
      }

      public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idsucursal,
                  A.telefono,
                  A.direccion,
                  A.linkmapa
                FROM $this->table  ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
      
      public function guardar() {
        $sql = "UPDATE sucursales SET
            telefono='$this->telefono',
            direccion=$this->direccion,
            linkmapa=$this->linkmapa
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }
}