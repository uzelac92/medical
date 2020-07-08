var app = angular.module("medcards",['ngRoute','ui.bootstrap','cleave.js','angularFileUpload']);

feather.replace();

app.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('!');
    $routeProvider
    .when("/", {
        templateUrl : "pages/index.html",
        controller: "userCtrl"
    })
    .when("/login", {
        templateUrl : "pages/signin.html"
    })
    .when("/register", {
        templateUrl : "pages/signup.html"
    })
    .when("/verify", {
        templateUrl : "pages/verify.html"
    })
    .when("/reset", {
        templateUrl : "pages/reset.html"
    })
    .when("/error503", {
        templateUrl : "pages/page-503.html"
    })
    .when("/home", {
        templateUrl : "pages/index.html"
    })
    .when("/panel", {
        templateUrl : "pages/panel.html"
    })
    .otherwise({
        redirectTo: '/'
    });
});

app.controller('customDialogCtrl', function ($scope, $uibModalInstance, $rootScope,userservice,$timeout,$route) {
    $scope.manual ={
        salute: "Mx"
    };
    $scope.modalType = localStorage.getItem('modalType');
    if($scope.modalType == 'Edit'){
        $scope.UIDtype = localStorage.getItem('usertype');
        if($scope.UIDtype == 1){
            var cont = JSON.parse(localStorage.getItem('cont'));
            $scope.manual = {
                id: cont.ID,
                salute: cont.SALUTE,
                fname: cont.FNAME,
                lname: cont.LNAME,
                mail: cont.USEMAIL,
                phone: cont.PHONE,
                address: cont.ADDRESS,
                notes: cont.NOTES,
                dob: cont.DOB,
                zip: cont.ZIP,
                city: cont.CITY,
                insurance: cont.INSURANCE
            }
        } else {
            var cont = JSON.parse(localStorage.getItem('userJSON'));
            $scope.manual = {
                id: cont.id,
                salute: cont.salute,
                fname: cont.fname,
                lname: cont.lname,
                mail: cont.usemail,
                phone: cont.phone,
                address: cont.adres,
                notes: cont.notes,
                dob: cont.dob,
                zip: cont.zip,
                city: cont.city,
                insurance: cont.insurance
            }
        }
    }

    $rootScope.$on("CallParentMethod", function () {
      $uibModalInstance.dismiss('Canceled');
  
    });
  
    $scope.cancel = function () {
        localStorage.removeItem('consid');
        $uibModalInstance.dismiss('Canceled');
    };

    $scope.onCreditCardValueChanged = function(e) {
        $scope.model.creditCardFormattedValue = e.target.value;
    };

    $scope.onCreditCardTypeChanged = function(type) {
        $scope.model.creditCardType = type;
    };

    $scope.model = {
        date: '',
    };

    $scope.cleaveDate = {
        date: {
            date: true,
            delimiters:['.']
        }
    };
    
    $scope.userUpdate = function(manul) {
        if(manul != undefined){
            if(manul.dob.length != 10)
                manul.dob = manul.dob.substring(0, 2)+'.'+manul.dob.substring(2, 4)+'.'+manul.dob.substring(4, 8);
            userservice.updateUser(manul).then(function(respo){
                console.log(respo);
                if(respo.data.status == "success"){
                    toastr.success("Successful update");
                    $timeout(function () { $route.reload(); }, 0);
                } else {
                    toastr.error("Unsuccessful update");
                }
            });
        }
    }
    $scope.initRecords = function() {
        var cont = JSON.parse(localStorage.getItem('userJSON'));
        $scope.manual = {
            id: cont.id,
            salute: cont.salute,
            fname: cont.fname,
            lname: cont.lname,
            mail: cont.usemail,
            phone: cont.phone,
            address: cont.adres,
            notes: cont.notes,
            dob: cont.dob,
            zip: cont.zip,
            city: cont.city,
            insurance: cont.insurance
        }
    }

    $scope.createConsultation = function(manual) {
        var cont = JSON.parse(localStorage.getItem('userJSON'));
        if(manual == undefined) {
            toastr.error("Insert data");
        } else if(manual.period == '' || manual.period == undefined) {
            toastr.error("Select interval of consultation record ");
        } else if(manual.startdate == '' || manual.startdate == undefined) {
            toastr.error("Select start date of consultation record ");
        } else if(manual.fname == '' || manual.fname == undefined) {
            toastr.error("Insert your first name. ");
        } else if(manual.lname == '' || manual.lname == undefined) {
            toastr.error("Insert your last name.");
        } else if(manual.dob == '' || manual.dob == undefined) {
            toastr.error("Insert your address. ");
        } else if(manual.zip == '' || manual.zip == undefined) {
            toastr.error("Insert ZIP code.");
        } else if(manual.city == '' || manual.city == undefined) {
            toastr.error("Insert your city.");
        } else if(manual.insurance == '' || manual.insurance == undefined) {
            toastr.error("Insert your insurance number.");
        } else {
            $scope.showCreateConsultation = true;
            manual.startdate = manual.startdate.substring(0, 2)+'.'+manual.startdate.substring(2, 4)+'.'+manual.startdate.substring(4, 8);
            manual.consid = localStorage.getItem('consid');
            userservice.newTask(manual).then(function(response){
                if(response.data.status == 'success'){
                    toastr.success("Task created","Success");
                } else {
                    toastr.error("Failed to create task.","Error");
                }
            }).catch(err => console.log(err));
        }
    }
    
});