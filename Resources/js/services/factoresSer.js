"use strict";
app.service('factorService', function ($http, $httpParamSerializerJQLike) {
	
	this.listarMunicipios = function (depto, tipo) {       
        var promise = $http({
            method: "post",
            url: "Controllers/listarMunicipios.php",
            data: $httpParamSerializerJQLike({
                idDepartamento:depto,
                tipo:tipo
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarBarrios = function (municipio) {       
        var promise = $http({
            method: "post",
            url: "Controllers/listarBarrios.php",
            data: $httpParamSerializerJQLike({
                idMunicipio:municipio
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarLideres = function (barrio) {       
        var promise = $http({
            method: "post",
            url: "Controllers/listarLiderComBarrio.php",
            data: $httpParamSerializerJQLike({
                barrio:barrio
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarGravedades = function (barrio) {       
        var promise = $http({
            method: "post",
            url: "Controllers/listarGravedad.php",
            data: $httpParamSerializerJQLike({
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarTipoFactor = function (barrio) {       
        var promise = $http({
            method: "post",
            url: "Controllers/listarTipoRiesgo.php",
            data: $httpParamSerializerJQLike({
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.registrar = function (lider, barrio, descripcion, gravedad, tipoRiesgo, fechaReporte) {       
        var promise = $http({
            method: "post",
            url: "Controllers/registrarFactorRiesgo.php",
            data: $httpParamSerializerJQLike({
                liderComunitario: lider,
                barrio: barrio,
                descripcion: descripcion,
                gravedad: gravedad,
                tipoRiesgo:tipoRiesgo,
                fechaReporte: fechaReporte}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarFactores=function(pag){
        var promise = $http({
            method: "post",
            url: "Controllers/listarFactoresRiesgo.php",
            data: $httpParamSerializerJQLike({
                page:pag
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }

    this.listarFactoresLimit=function(limite){
        var promise = $http({
            method: "post",
            url: "Controllers/listarFactoresRiesgo.php",
            data: $httpParamSerializerJQLike({
                limite:limite
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }

    this.editar = function (factor, lider, barrio, descripcion, gravedad, tipoRiesgo, fechaReporte) {       
        var promise = $http({
            method: "post",
            url: "Controllers/actualizarFactorRiesgo.php",
            data: $httpParamSerializerJQLike({
                idEvento: factor,
                liderComunitario: lider,
                barrio: barrio,
                descripcion: descripcion,
                gravedad: gravedad,
                tipoRiesgo:tipoRiesgo,
                fechaReporte: fechaReporte}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    //solucion
    this.consultarSolucionFactor= function(factor){
        var promise = $http({
            method: "post",
            url: "Controllers/listarSolucion.php",
            data: $httpParamSerializerJQLike({
                idEvento: factor}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }
    this.listarEntidades=function(municipio){
        var promise=$http({
            method:"post",
            url:"Controllers/listarEntidadResponsable.php",
            data: $httpParamSerializerJQLike({
                idMunicipio: municipio
            }),
            headers:{'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response){
            return response;
        }, function myError(response){
            return response;
        });

        return promise;
    }
    this.listarEstadosSolucion=function(municipio){
        var promise=$http({
            method:"post",
            url:"Controllers/listarEstadoSolucion.php",
            data: $httpParamSerializerJQLike({}),
            headers:{'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response){
            return response;
        }, function myError(response){
            return response;
        });

        return promise;
    }
    this.solucionar=function(entidad, estado, fechaN, fechaS, descripcionSln, evento){
        var promise = $http({
            method: "post",
            url: "Controllers/solucionar.php",
            data: $httpParamSerializerJQLike({
                idEntidadResponsable:entidad,
                estadoSolucion:estado,
                fechaNotificacion:fechaN,
                fechaSolucion:fechaS,
                descripcion:descripcionSln, 
                idEvento: evento}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }
});
