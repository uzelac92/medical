app.controller("contCtrl", function($scope, $uibModal,adminservice,webservice,$timeout,$route) {

    $scope.listusers = function(){
        adminservice.getUsers().then(function(resp){
            if(resp.data.status=='success'){
                $scope.contacts = resp.data.contacts.reduce((a, c) => {
                    let k = c["LNAME"][0].toLocaleUpperCase()
                    if (a[k]) a[k].push(c)
                    else a[k] = [c]
                    return a
                }, {});
            }
        });
    }

    $scope.templateModal = function(val,cont) {
        localStorage.setItem('modalType',val);
        localStorage.setItem('cont', JSON.stringify(cont));
        $uibModal.open({
            templateUrl: 'pages/addEditContact.html',
            controller: 'customDialogCtrl',
            size: 'md',
        }).result.catch(function (resp) {
            if (['cancel', 'backdrop click', 'escape key press'].indexOf(resp) === -1);
        });
    }

    $scope.deleteContact = function(id) {
        localStorage.setItem('deleteID',id);
        $uibModal.open({
            templateUrl: 'pages/deleteContact.html',
            controller: 'customDialogCtrl',
            size: 'sm',
        }).result.catch(function (resp) {
            if (['cancel', 'backdrop click', 'escape key press'].indexOf(resp) === -1);
        });
    }

    function generatePassword() {
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }

    $scope.manualRegister = function(manual) {
        if(manual===undefined){
            toastr.error('Insert contact details')
        } else if(manual.salute == '' || manual.salute===undefined){
            toastr.error('Select contact salute')
        } else if(manual.fname == '' || manual.fname===undefined){
            toastr.error('Insert contact first name')
        } else if(manual.lname == '' || manual.lname===undefined){
            toastr.error('Insert contact last name')
        } else if(manual.mail == '' || manual.mail===undefined){
            toastr.error('Insert contact e-mail')
        } else {
            var vData = {
                salute: manual.salute,
                fname: manual.fname,
                lname: manual.lname,
                mail: manual.mail,
                pass: generatePassword(),
                phone: manual.phone == undefined ? "":manual.phone,
                address: manual.address == undefined ? "":manual.address,
                notes: manual.notes == undefined ? "":manual.notes,
                zip: manual.zip == undefined ? "":manual.zip,
                city: manual.city == undefined ? "":manual.city,
                dob: manual.dob == undefined ? "":manual.dob,
                insurance: manual.insurance  == undefined ? "":manual.insurance
            }
            webservice.verifyUser(manual.mail).then(function(getData){
                if(getData.data.status == 'success') {
                    toastr.error("Account with this e-mail already exist!");
                } else {
                    adminservice.registerUser(vData).then(function(respo){
                        if(respo.data.status == "success"){
                            toastr.success("Successful registration");
                            $timeout(function () { $route.reload(); }, 0);
                            $scope.listusers();
                        } else {
                            toastr.error("Unsuccessful registration");
                        }
                    });
                }
            });
        }
    }

    $scope.manualUpdate = function(obj) {
        adminservice.checkUser(obj.id).then(function(getData){
            if(getData.data.status == 'success') {
                adminservice.updateUser(obj).then(function(respo){
                    if(respo.data.status == "success"){
                        toastr.success("Successful update");
                        $timeout(function () { $route.reload(); }, 0);
                    } else {
                        toastr.error("Unsuccessful update");
                    }
                });
            } else {
                toastr.error("Account with this e-mail doesn't exist!");
            }
        });
    }

    $scope.manualDelete = function() {
        var userID = localStorage.getItem('deleteID');
        adminservice.checkUser(userID).then(function(getData){
            if(getData.data.status == 'success') {
                adminservice.deleteUser(userID).then(function(respo){
                    if(respo.data.status == "success"){
                        toastr.success("Successfuly deleted");
                        $timeout(function () { $route.reload(); }, 0);
                    } else {
                        toastr.error("Couldn't delete");
                    }
                });
            } else {
                toastr.error("Account with this e-mail doesn't exist!");
            }
        });
    }

    $scope.displayIt = function(con){
        $scope.selected = con;
    }
})