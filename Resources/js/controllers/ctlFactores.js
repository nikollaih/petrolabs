"use strict";
app.controller('factorController', function ($scope, $window, $timeout, factorService) {

    $scope.paginas=new Array();
    $scope.getNumber = function() {
        LiderService.paginas().then(
            function(response){
                console.log(response);
                for (var i = 1; i <= response.data; i++) {
                    $scope.paginas.push(i);
                };
            });   
    }

	$scope.barrio="0";
	$scope.lider="0";

	$scope.listarMunicipios=function(){
		factorService.listarMunicipios(1, 1).then(
			function(response){
                console.log(response);
				$scope.municipios=response.data;
            	$scope.municipio="0";
			}
		);
	}

	$scope.listarBarriosMunicipio=function(){
		factorService.listarBarrios($scope.municipio).then(
			function(response){
				$scope.barrios=response.data;
            	$scope.barrio="0";
			}
		);
	}

	$scope.listarLideres=function(){
		factorService.listarLideres($scope.barrio).then(
			function(response){
				$scope.lideres=response.data;
				$scope.lider="0";
			}
		);
	}

	$scope.listarGravedades=function(){
		factorService.listarGravedades().then(
			function(response){
				$scope.gravedades=response.data;
				$scope.gravedad="0";
			}
		);
	}

	$scope.listarTipoFactor=function(){
		factorService.listarTipoFactor().then(
			function(response){
				$scope.tipos=response.data;
				$scope.tipo="0";
			}
		);
	}

	$scope.registrar=function(){
        if ($scope.municipio!="0" && $scope.barrio!="0" && $scope.lider!="0" && $scope.gravedad!="0" &&
        	$scope.tipo!="0") {
        	factorService.registrar($scope.lider, $scope.barrio, $scope.descripcion, $scope.gravedad,
			$scope.tipo, $scope.fecha).then(
				function(response){
					if(response.data==1){
                        $scope.colorText='success';
                        $scope.msj='Registrado exitosamente!';
                        $scope.limpiarCampos();
                        $scope.listarFactoresLimit();
                        $timeout( function(){ 
                            $scope.msj="";
                        }, 3000);
                    }
                    if (response.data==-1) {
                        $scope.colorText='error';
                        $scope.msj='Error al registrar!';
                        $timeout( function(){ $scope.msj=""; }, 3000);
                    }
                    if (response.data==0) {
                        $scope.colorText='error';
                        $scope.msj="Hubo un error en los datos enviados.";
                        $timeout( function(){ $scope.msj=""; }, 3000);
                    }
				}
			);
        }else{
            $scope.colorText='error';
            $scope.msj="Seleccione.";
            $timeout( function(){ $scope.msj=""; }, 3000);
        }
    }

    $scope.listarFactores=function(pag){
    	factorService.listarFactores(pag).then(function(response){
    		$scope.factores=response.data;
    	});
    }

    $scope.listarFactoresLimit=function(){
    	factorService.listarFactoresLimit("5").then(function(response){
    		$scope.factores=response.data;
    	});
    }

    $scope.limpiarCampos=function(){
    	$scope.lider="0";
    	$scope.municipio="0";
    	$scope.barrio="0";
    	$scope.descripcion="";
    	$scope.gravedad="0";
		$scope.tipo="0";
		$scope.fecha="";
    }
    $scope.datos=function(obj){
    	$scope.factor=obj.idEvento;
    	$scope.municipio=obj.idMunicipio;
    	$scope.listarBarriosMunicipio();
    	$scope.barrio=obj.idBarrio;
    	$scope.listarLideres();
    	$scope.lider=obj.idUsuario;
    	$scope.tipo=obj.idTipoRiesgo;
    	$scope.gravedad=obj.idGravedad;
    	var t = obj.fecha.split(/[- :]/);
        $scope.fecha= new Date(t[0],t[1]-1,t[2]);
    	$scope.descripcion=obj.descripcion;
    }

    $scope.editar=function(){
        if ($scope.municipio!="0" && $scope.barrio!="0" && $scope.lider!="0" && $scope.gravedad!="0" &&
        	$scope.tipo!="0") {
        	console.log($scope.fecha);
        	factorService.editar($scope.factor, $scope.lider, $scope.barrio, $scope.descripcion, $scope.gravedad,
			$scope.tipo, $scope.fecha).then(
				function(response){
					console.log(response);
					if(response.data==1){
                        $scope.colorText='success';
                        $scope.msj='Editado exitosamente!';
                        $scope.limpiarCampos();
                        $scope.listarFactores();
                        $timeout( function(){ 
                            $scope.msj="";
                        }, 3000);
                        $timeout( function(){ $('#myModal').modal('hide'); }, 1000);
                    }
                    if (response.data==-1) {
                        $scope.colorText='error';
                        $scope.msj='Error al Editar!';
                        $timeout( function(){ $scope.msj=""; }, 3000);
                    }
                    if (response.data==0) {
                        $scope.colorText='error';
                        $scope.msj="Hubo un error en los datos enviados.";
                        $timeout( function(){ $scope.msj=""; }, 3000);
                    }
				}
			);
        }else{
            $scope.colorText='error';
            $scope.msj="Seleccione.";
            $timeout( function(){ $scope.msj=""; }, 3000);
        }
    }


    //Solución
    $scope.datosSolucion=function(obj){
        $scope.eventoSln=obj.idEvento;
    	factorService.consultarSolucionFactor(obj.idEvento).then(function(response){
            if (response.data==0) {
                $scope.cargarCombosSolucion(obj);
            }else{
                console.log(response);
                $scope.cargarCombosSolucion(obj);
            }
        });
    }
    $scope.cargarCombosSolucion=function(obj){
        factorService.listarEntidades(obj.idMunicipio).then(function(response){
            $scope.entidades=response.data;
            $scope.entidad="0";
        });
        factorService.listarEstadosSolucion().then(function(response){
            $scope.estados=response.data;
            $scope.estado="0";
        });
    }
    $scope.solucionar=function(){
        factorService.solucionar($scope.entidad, $scope.estado, $scope.fechaN, $scope.fechaS, $scope.descripcionSln, 
            $scope.eventoSln).then(
            function(response){
                console.log(response);
                if (response.data==1) {

                }
            });
    }
});