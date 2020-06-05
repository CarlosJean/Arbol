<?php

class Tree{

    private $_arrayList = array();

    //Crea un nuevo arreglo, asignando el indice dependiendo del id del elemento padre.
    function clasificarElementosHermanos($array,$parentId){
        $new = array();
        foreach($array as $element){
            $new[$element[$parentId]][] = $element;
        }
        return $new;
    }

    function crearArbol(&$lista, $padre){

        $arbol = array();
        foreach($padre as $k => $l){ 
            
            //Verifica si es padre, para buscar a los hijos.
            if(isset($lista[$l['id']])){
        
                //Sumar el monto que tiene el elemento padre con el monto de los elementos hijos.
                for($i = 0; $i<count($lista[$l['id']]);$i++){
                    $l['monto']+= $lista[$l['id']][$i]['monto'];
                }

                //Añadir los elementos hijos al elemento padre.
                $l['hijo'] = $this->crearArbol($lista, $lista[$l['id']]);
                
            }

            //Se añade al arbol.
            $arbol[] = $l;
         }

        return $arbol;
    }


}


$master = array(array('id'=>1,'nombre_cuenta'=>'Activo','padre'=>0, 'monto'=>1000),
                array('id'=>2,'nombre_cuenta'=>'Cuentas por pagar','padre'=>1, 'monto'=>1000),
                array('id'=>3,'nombre_cuenta'=>'Cuentas por pagar','padre'=>1, 'monto'=>1000),
                array('id'=>4,'nombre_cuenta'=>'Cuentas por pagar','padre'=>0, 'monto'=>1000),
                array('id'=>5,'nombre_cuenta'=>'Cuentas por pagar','padre'=>2, 'monto'=>1000));

$tree = new Tree();

$arrayList = $tree->clasificarElementosHermanos($master,'padre');

//print_r($arrayList);
$arbol = $tree->crearArbol($arrayList,$arrayList[0]);
echo json_encode($arbol);

/* 

    1- Se clasifican por grupos a los padres y los hijos. Los padres se colocan en el indice 0, 
        y los demás hijos se asignan al indice correspondiente al indice del padre.

    2- Se buscan los hijos en el arreglo que los clasificó, se busca por el id del padre.

*/