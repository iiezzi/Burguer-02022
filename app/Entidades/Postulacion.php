<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
      protected $table = 'postulaciones';
      public $timestamps = false;
  
      protected $fillable = [
          'idpostulacion', 'nombre', 'apellido', 'telefono', 'correo', 'curriculum',
      ];
  
      protected $hidden = [
  
      ];

      public function insertar()
      {
          $sql = "INSERT INTO $this->table(
                  nombre,
                  apellido,
                  telefono,
                  correo,
                  curriculum
              ) VALUES (?, ?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->apellido,
              $this->telefono,
              $this->correo,
              $this->curriculum,
          ]);
          return $this->idpostulacion = DB::getPdo()->lastInsertId();
      }

      public function obtenerPorId($idpostulacion)
      {
          $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  telefono,
                  correo,
                  curriculum
                  FROM $this->table WHERE idpostulacion = $idpostulacion";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idpostulacion = $lstRetorno[0]->idpostulacion;
              $this->nombre = $lstRetorno[0]->nombre;
              $this->apellido = $lstRetorno[0]->apellido;
              $this->telefono = $lstRetorno[0]->telefono;
              $this->correo = $lstRetorno[0]->correo;
              $this->curriculum = $lstRetorno[0]->curriculum;
              return $this;
          }
          return null;
      }

      public function obtenerTodos()
    {
        $sql = "SELECT
                  idpostulacion,
                  nombre,
                  apellido,
                  telefono,
                  correo,
                  curriculum
                FROM $this->table  ORDER BY nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
      
      public function guardar() {
        $sql = "UPDATE postulaciones SET
            nombre='$this->nombre',
            apellido=$this->apellido,
            telefono=$this->telefono,
            correo=$this->correo,
            curriculum='$this->curriculum'
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM $this->table WHERE idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }
}