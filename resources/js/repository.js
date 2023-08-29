import barrelImage from '../images/repository/barrel.png';
import beerImage from '../images/repository/beer.png';
import dynamiteImage from '../images/repository/dynamite.png';

const REPOSITORY_URL = '/repository';
const REPOSITORY_FILE_URL = '/repository-file?p=';

function getFilePathFromUrl() {
  // Retrieve file path after page anchor.
  return window.location.hash.slice(1);
}

function goToUrl(url) {
  window.location.href = url;
}

function onHistoryChange(callback) {
  window.onpopstate = callback;
}

function pushUrlInHistory(url) {
  window.history.pushState({}, null, url);
}

function Repository() {
  const self = this;

  const goBackButton = document.querySelector('#js_goBackButton');
  const currentFilePathText = document.querySelector('#js_currentFilePathText');
  const childFileList = document.querySelector('#js_childFileList');
  const fileContentBlock = document.querySelector('#js_fileContentBlock');
  const fileDescriptionBlock = document.querySelector('#js_fileDescriptionBlock');
  const fileDescriptionText = document.querySelector('#js_fileDescriptionText');

  let currentFile = null;

  function constructor() {
    handleClickOnGoBackButton();

    self.loadFilePathFromUrl();
  }

  function handleClickOnGoBackButton() {
    goBackButton.addEventListener('click', function () {
      goToFilePath(currentFile.relativeParentPath);
    });
  }

  // This function is called from outside below.
  this.loadFilePathFromUrl = function () {
    loadFilePath(getFilePathFromUrl());
  };

  function loadFilePath(path) {
    fetch(REPOSITORY_FILE_URL + path)
      .then(function (response) {
        return response.json(); // Assume that call never fails.
      })
      .then(function (data) {
        currentFile = data.file;
        updateGui(data.file);
      });
  }

  function updateGui(file) {
    prepareUpdate();
    showFilePath(file);

    if (file.isDir) {
      showChildFileList(file);
    } else {
      showFileContent(file);
    }

    if (file.description) {
      showFileDescription(file);
    }
  }

  function prepareUpdate() {
    childFileList.classList.add('d-none');
    fileContentBlock.classList.add('d-none');
    fileDescriptionBlock.classList.add('d-none');
  }

  function showFilePath(file) {
    currentFilePathText.innerHTML = file.relativePath;
  }

  function showChildFileList(file) {
    childFileList.innerHTML = null;

    addChildFileListItems(file);

    childFileList.classList.remove('d-none');
  }

  function addChildFileListItems(parentFile) {
    parentFile.childFiles.forEach(function (childFile) {
      const item = document.createElement('li');

      setFileListItemText(item, childFile);
      handleClickOnListItem(item, childFile);

      childFileList.append(item);
    });
  }

  function setFileListItemText(item, file) {
    item.innerHTML = `<img src=${ getIconImage(file) } class="me-1" /> ${ file.name }`;

    item.classList.add('text-primary', 'list-none', 'mb-1');
    item.setAttribute('role', 'button');
  }

  function getIconImage(file) {
    return file.isDir ? barrelImage : (file.isArchive ? dynamiteImage : beerImage);
  }

  function handleClickOnListItem(item, file) {
    item.addEventListener('click', function () {
      if (file.isArchive || file.isImage || file.isPdf) {
        goToUrl(file.storagePath);
        return;
      }

      goToFilePath(file.relativePath);
    });
  }

  function showFileContent(file) {
    fileContentBlock.innerHTML =
      '<a href="' + file.storagePath + '" download="'
      + file.name + '" class="btn btn-brown font-duality mb-3">'
      + '<i class="bi-download"></i> Télécharger'
      + '</a>'
      + '<pre><code class="hljs">' + file.content + '</code></pre>';

    fileContentBlock.classList.remove('d-none');
  }

  function showFileDescription(file) {
    fileDescriptionText.innerHTML = file.description.replace(/<currentDir>/g, file.storagePath);
    fileDescriptionBlock.classList.remove('d-none');
  }

  function goToFilePath(path) {
    loadFilePath(path);

    pushUrlInHistory(REPOSITORY_URL + '#' + path);
  }

  constructor();
}

const repository = new Repository();

onHistoryChange(function () {
  repository.loadFilePathFromUrl();
});