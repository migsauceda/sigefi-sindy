app.controller("Controllerhabitaciones", function Controllerhabitaciones($scope, $location, $http, $q){
    $scope.typeSubmit = 1;
$scope.CurrentHabitaciones={};


     $scope.submit = function(){
			ServicesImpuestos
			.postNew(JSON.stringify({
				id:$scope.CurrentImpuestos.id,
				descripcion:$scope.CurrentImpuestos.descripcion,
                cantidad:$scope.CurrentImpuestos.cantidad}),$scope.typeSubmit,'impuestos')
			.then(function(response){
				if(response.status == 200){
					if($scope.typeSubmit == 2)
						Notification("Registro Actualizado");
					else if($scope.typeSubmit == 1)
						Notification("Registro Guardada");
					else if($scope.typeSubmit == 3)
						Notification("Registro Borrado");
					
					  $scope.loadimpuestos();
				}
				else{
					$scope.handlerError(response,"","Credenciales necesarias", "No hay ninguna agencia en este momento", "Error al realizar la consulta", true);
				}			
				
			})
			["catch"](function(err) {
			//catch error de peticion
				var E_404_msg = "";
				switch($scope.typeSubmit){
					case 1:
						E_404_msg = "Error al guardar la solicitud";
						break;
					case 3:
						E_404_msg = "Error al borrar la solicitud";
						break;
					default:
						E_404_msg = "Error al actualizar la solicitud";

				}
				$scope.handlerError(err,E_404_msg,"Credenciales necesarias", "No hay ning\372n usuario en este momento", "Error al realizar la consulta", true);
			});
		 }

	$scope.ActualizarImpuestos=function(impuestos){
        //alert(JSON.stringify(impuestos));
		$scope.typeSubmit = 2;
		$scope.CurrentImpuestos=impuestos;
	}

    $scope.loadimpuestos=function(){
	  ServicesImpuestos.getimpuestos()
	   .then(function(response){
		 var responseService = $scope.responseFilter(response);
		 $scope.resimpuestos = responseService != false ? responseService : [];
		})
		["catch"](function(err){
			$scope.handlerError(err,"Error al obtener todas las cotizaciones","Credenciales necesarias", "No hay Empleados en este momento", "Error al realizar la consulta", true);
       	})	
	}

    $scope.loadimpuestos();

    $scope.responseFilter = function(response){
        if(response.status == 200){
            if(response.data.length > 0){
                return response.data;
            }
            else{
                Notification.warning("No tiene Elementos Asignados");
                return false;
            }
        }else{
            $scope.handlerError(response,"","Credenciales necesarias", "No tiene Elementos Asignados", "Error al realizar la consulta", true);
            return false;
        }
    }

    $scope.responseFilterStatus = function(response, message){
        if(response.status == 200){
            if(response.data.length > 0){
                Notification.success(message);
            }
            else{
                return false;
            }
        }else{
            $scope.handlerError(response,"","Credenciales necesarias", "No tiene Elementos Asignados", "Error al realizar la consulta", true);
            return false;
        }
    }

    $scope.handlerError = function(err, E_404,E_403,E_204,E_D,login){
		switch(err.status){
			case 404:
				Notification.errorr(E_404);
			break;
			case 403:
				Notification.error(E_403);
				if(login)
					$location.path("login");
			break;
		
			default:
				Notification.error(E_D);
		}
	}

    
   
});

/*app.service("ServicesPrincipal", function ServicesDataLogin($http, $q, $location){

});*/
