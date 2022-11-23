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
  
      protected $hidden = [];

      public function cargarDesdeRequest($request)
      {
          $this->idpostulacion = $request->input('id') != "0" ? $request->input('id') : $this->idpostulacion;
          $this->nombre = $request->input('txtNombre');
          $this->apellido = $request->input('txtApellido');
          $this->telefono = $request->input('txtTelefono');
          $this->correo = $request->input('txtCorreo');
          $this->curriculum = $request->input('txtCurriculum');
      }

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
                    A.idpostulacion,
                    A.nombre,
                    A.apellido,
                    A.telefono,
                    A.correo,
                    A.curriculum
                  FROM $this->table A ORDER BY A.nombre";
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

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpostulacion',
            1 => 'A.nombre',
            2 => 'A.telefono',
            3 => 'A.correo',
            4 => 'A.curriculum'
        );
        $sql = "SELECT DISTINCT
                    A.idpostulacion,
                    A.nombre,
                    A.apellido,
                    A.telefono,
                    A.correo,
                    A.curriculum
                    FROM postulaciones A
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR B.apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR C.telefono LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR D.correo LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}