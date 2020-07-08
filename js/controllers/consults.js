app.controller("consultCtrl", function($scope,FileUploader){

    var uploader = $scope.uploader = new FileUploader({
        url: '/api/upload.php'
    });

    uploader.filters.push({
        name: 'syncFilter',
        fn: function(item, options) {
            return this.queue.length < 10;
        }
    });
  
    uploader.filters.push({
        name: 'asyncFilter',
        fn: function(item, options, deferred) {
            setTimeout(deferred.resolve, 1e3);
        }
    });

    uploader.onAfterAddingFile = function(item) {
        var fileExtension = '.' + item.file.name.split('.').pop();
        item.file.name = new Date().toISOString() + fileExtension;
    };
    
})