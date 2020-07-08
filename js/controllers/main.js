app.controller("mainCtrl",function($scope){

    $scope.putanja = "/pages/contacts.html";
    $scope.postaviLink = function (link){
        $scope.putanja = "/pages/"+link+".html";
    }

})