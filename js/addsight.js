$(function(){
    var viewModel = {};
    viewModel.fileData = ko.observable({
      dataURL: ko.observable(),
      // base64String: ko.observable(),
    });
    viewModel.multiFileData = ko.observable({
      dataURLArray: ko.observableArray(),
    });
    viewModel.onClear = function(fileData){
      if(confirm('你確定嗎?')){
        fileData.clear && fileData.clear();
      }
    };
    viewModel.debug = function(){
      window.viewModel = viewModel;
      console.log(ko.toJSON(viewModel));
      debugger;
    };
    ko.applyBindings(viewModel);
  });

