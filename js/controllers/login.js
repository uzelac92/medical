app.controller("logCtrl",function($scope,$location,webservice,$timeout,$route){
    var type = localStorage.getItem('usertype');
    var diff = Math.abs(new Date().getTime() - localStorage.getItem('sesTime')) / 3600000;
    if(type > 0 && diff < 2){
        var url = $location.url();
        if(url === '/login') {
            localStorage.clear();
            $location.path('/login');
        } else if(url === '/register') {
            localStorage.clear();
            $location.path('/register');
        } else if(url === '/reset') {
            localStorage.clear();
            $location.path('/reset');
        } else {
            if(type==1) {
                $location.path('/panel');
            } else if(type==2){
                var mejl = localStorage.getItem('mail');
                webservice.checkVerified(mejl).then(function(response){
                    if(response.data.status == 'success') {
                        var verify = response.data.verified;
                        if(verify.length > 0) {
                            $location.path('/verify');  
                        } else {
                            $location.path('/');
                        }
                    } else {
                        toastr.warning('Please verify your account');
                        $location.path('/login');
                    }
                })
            }
        }
    } else {
        var url = $location.url();
        localStorage.clear();
        if(url != '/register') {
            $location.path('/login');
        }
    }

    $scope.registar ={
        salute: "Mx"
    };
    
    $scope.logIn = function(visitor) {
        if(visitor.mail == '' || visitor.mail === undefined) {
            toastr.error('Insert your username')
        } else if(visitor.pass == '' || visitor.pass === undefined) {
            toastr.error('Insert your password')
        } else {
            webservice.verifyUser(visitor.mail).then(function(getData){
                if(getData.data.status == 'success') {
                    webservice.getLoggin(visitor.mail,visitor.pass).then(function(response){
                        var resp = response.data;
                        if(resp.status="success") {
                            toastr.success('Successful login.');
                            localStorage.setItem('usertype',resp.usertype);
                            localStorage.setItem('sesTime',new Date().getTime());
                            localStorage.setItem('verification',resp.verif);
                            localStorage.setItem('mail',resp.usemail);
                            if(resp.verif.length) {
                                $location.path('/verify');
                            } else {
                                $location.path('/');
                                var useName = resp.lname + " " + resp.fname;
                                localStorage.setItem("headerName",useName);
                                localStorage.setItem("userID",resp.id);
                                localStorage.setItem("userMail",visitor.mail);
                                localStorage.setItem("userPass",visitor.pass);
                                localStorage.setItem('userJSON', JSON.stringify(resp));
                            }
                        }else {
                            toastr.error('User with this e-mail does not exist!');
                        }
                    });
                } else {
                    webservice.getAdmin(visitor.mail,visitor.pass).then(function(respo){
                        if(respo.data.status == 'success') {
                            toastr.success('Successful login.');
                            localStorage.setItem('usertype',respo.data.usertype);
                            localStorage.setItem('sesTime',new Date().getTime());
                            localStorage.setItem('uid',respo.data.uid);
                            localStorage.setItem('key',respo.data.key);
                            localStorage.setItem("headerName","Administrator")
                            $location.path('/panel');
                        } else {
                            toastr.error('User with this e-mail does not exist!');
                        }
                    })
                }
            })
            
        }
    }

    $scope.initHeader = function() {
        $scope.headerName = localStorage.getItem("headerName");
        $scope.headerType = localStorage.getItem('usertype');
    }

    $scope.logOut = function() {
        localStorage.clear();
        $location.path('/login');
    }

    $scope.registerUser = function(reg) {
        if(reg.mail == '' || reg.mail===undefined){
            toastr.error('Insert your e-mail')
        } else if(reg.pass == '' || reg.pass===undefined){
            toastr.error('Insert your password')
        } else if(reg.salute == '' || reg.salute===undefined){
            toastr.error('Select your salute')
        } else if(reg.fname == '' || reg.fname===undefined){
            toastr.error('Insert your first name')
        } else if(reg.lname == '' || reg.lname===undefined){
            toastr.error('Insert your last name')
        } else {
            var vData = {
                mail: reg.mail,
                pass: reg.pass,
                salute: reg.salute,
                fname: reg.fname,
                lname: reg.lname,
            }
            webservice.verifyUser(reg.mail).then(function(getData){
                if(getData.data.status == 'success') {
                    toastr.error("Account with this e-mail already exist!");
                } else {
                    webservice.registerUser(vData).then(function(response){
                        if(response.data.status == "success"){
                            toastr.success("Successful registration");
                            var data = {
                                code: response.data.code,
                                mejl: response.data.mail
                            }
                            localStorage.setItem('verification',data.code);
                            localStorage.setItem('mail',data.mejl);
                            webservice.sendVerification(data).then(function(resp){
                                toastr.success("Verification sent to e-mail.");
                            });
                            $location.path('/verify');
                        } else {
                            toastr.error("Unsuccessful registration");
                        }
                    });
                }
            });
        }
    }

    $scope.resendVer = function() {
        var data = {
            code: localStorage.getItem('verification'),
            mejl: localStorage.getItem('mail')
        }
        webservice.sendVerification(data).then(function(resp){
            toastr.success("Verification sent to e-mail.");
        });
    }

    $scope.resetPass = function(mail) {
        if(mail == '' || mail === undefined){
            toastr.error('Insert your e-mail');
        } else {
            webservice.verifyUser(mail).then(function(getData){
                if(getData.data.status == 'success') {
                    webservice.resetPassword(mail).then(function(response){
                        if(response.data.status == 'success') {
                            var data = {
                                mejl: mail,
                                pass: response.data.newPass
                            }
                            webservice.sendPassword(data).then(function(respo){
                                if(respo.data.status == 'success') {
                                    toastr.success('New password is sent to your e-mail');
                                    $timeout(function () { $route.reload(); }, 0);
                                } else {
                                    toastr.error('Error with new password. Contact support.');
                                }
                            })
                        } else {
                            toastr.error('Error with new password. Contact support.');
                        }
                    })
                } else {
                    toastr.error('Account with this e-mail does not exist!');
                }
            })
            
        }
    }

})