app.controller("Controllerdescuentos", function Controllerdescuentos($scope, $location, $http, $q,Notification,ServicesDescuento){
    
 $scope.typeSubmit = 1;
 $scope.CurrentDescuentos={};


     $scope.submit = function(){
			ServicesDescuento
			.postNew(JSON.stringify({
				id:$scope.CurrentDescuentos.id,
				descripcion:$scope.CurrentDescuentos.descripcion,
                porcentaje:$scope.CurrentDescuentos.porcentaje}),$scope.typeSubmit,'descuentos')
			.then(function(response){
				if(response.status == 200){
					if($scope.typeSubmit == 2)
						Notification("Registro Actualizado");
					else if($scope.typeSubmit == 1)
						Notification("Registro Guardada");
					else if($scope.typeSubmit == 3)
						Notification("Registro Borrado");
					
					  $scope.loaddescuentos();
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

	$scope.ActualizarDescuento=function(descuento){
		$scope.typeSubmit = 2;
		$scope.CurrentDescuentos=descuento;
	}

    $scope.loaddescuentos=function(){
	  ServicesDescuento.getdescuento()
	   .then(function(response){
		 var responseService = $scope.responseFilter(response);
		 $scope.resdescuentos = responseService != false ? responseService : [];
		})
		["catch"](function(err){
			$scope.handlerError(err,"Error al obtener todas las cotizaciones","Credenciales necesarias", "No hay Empleados en este momento", "Error al realizar la consulta", true);
       	})	
	}

    $scope.loaddescuentos();

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

app.service("ServicesDescuento", function ServicesDescuento($http, $q, $location){


var urlbase='http://localhost:1080/admin/backend/api/';

	this.getdescuento = function(){
        var defered = $q.defer();
        var promise = defered.promise;
        $http.get(urlbase+"descuentos")
        .success(function(data, status){
            //recibe de la api en php  array_push($data,$ressolicitud);
            var _data = {"data": data.resdescuentos, "status": status};
            defered.resolve(_data);
        })  
        .error(function(error, status){
            var _data = {"message":error, "status": status};
            defered.reject(_data)
        });
        return promise;
    }
        
	this.postNew= function(data,type,url){
		//$http.defaults.headers.common["XAuthToken"] = store.get("XAuthToken");
		var defered = $q.defer();
		var promise = defered.promise;
		var method = 'POST';
		switch(type){
			case 2:
			method = "PUT";
			break;
			case 3:
			method = "DELETE";
			break;
		}
		var req = {
		method: method,
		url: urlbase + url,
		headers: {
		  'Content-Type': 'application/json;charset=utf-8'
		},
		data: data,
		}
		$http(req).success(function(data, status){
			var _data = {"data":data,"status":data.status};
			defered.resolve(_data);
		}).error(function(error, status){
			var _edta = { message: error, status: status};
			defered.reject(_edta);
		});
		return promise;
	}
});
