"use strict";
var app = angular.module("appMaster", ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
            .when('/Usuarios/Registrar', {
                controller: 'UserController',
                templateUrl: 'views/users/createUser.html'
            })
            .when('/Usuarios/Lider', {
                controller: 'UserController',
                templateUrl: 'views/users/createLider.php'
            })
            .when('/Usuarios/Listar', {
                controller: 'UserController',
                templateUrl: 'views/users/listUsers.html'
            })
            .when('/Usuarios/ListarLideres', {
                controller: 'UserController',
                templateUrl: 'views/users/listLideres.html'
            })
            .when('/Factor/Registrar', {
                controller: 'factorController',
                templateUrl: 'views/factores/createFactor.php'
            })
            .when('/Factor/Listar', {
                controller: 'factorController',
                templateUrl: 'views/factores/listFactor.php'
            })
            .when('/Entidades/Registrar', {
                controller: 'entidadController',
                templateUrl: 'views/factores/createEntidad.php'
            })
            .when('/Entidades/Listar', {
                controller: 'entidadController',
                templateUrl: 'views/entidades/listEntidades.php'
            })
            .when('/Estadisticas', {
                templateUrl: 'views/graphics/Graphics.html'
            })
            .otherwise({
                redirectTo: '/',
                templateUrl: 'views/home.html'
            });
});
