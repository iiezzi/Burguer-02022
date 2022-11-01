<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
      protected $table = 'estados';
      public $timestamps = false;
  
      protected $fillable = [
          'idestado', 'nombre',
      ];
  
      protected $hidden = [
  
      ];

      public function insertar()
      {
          $sql = "INSERT INTO $this->table(
                  nombre
              ) VALUES (?);";
          $result = DB::insert($sql, [
              $this->nombre
          ]);
          return $this->idestado = DB::getPdo()->lastInsertId();
      }

      public function obtenerPorId($idestado)
      {
          $sql = "SELECT
                  idestado,
                  nombre
                  FROM $this->table WHERE idestado = $idestado";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idestado = $lstRetorno[0]->idestado;
              $this->nombre = $lstRetorno[0]->nombre;
              return $this;
          }
          return null;
      }

      public function obtenerTodos()
    {
        $sql = "SELECT
                  idestado,
                  nombre
                FROM $this->table  ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
      
      public function guardar() {
        $sql = "UPDATE estados SET
            nombre='$this->nombre',
            apellido=$this->apellido,
            correo=$this->correo,
            dni=$this->dni,
            celular='$this->celular',
            clave='$this->clave'
            WHERE idestado=?";
        $affected = DB::update($sql, [$this->idestado]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idestado=?";
        $affected = DB::delete($sql, [$this->idcliidestadoente]);
    }
}