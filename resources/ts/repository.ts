import barrelImage from '../images/repository/barrel.png';
import beerImage from '../images/repository/beer.png';
import dynamiteImage from '../images/repository/dynamite.png';

const REPOSITORY_URL: string = '/repository';
const REPOSITORY_FILE_URL: string = '/repository-file?p=';

interface CustomFile {
    name: string;
    description: string;
    content: string;

    relativePath: string;
    relativeParentPath: string;
    storagePath: string;

    isDir: boolean;
    isArchive: boolean;
    isImage: boolean;
    isPdf: boolean;

    childFiles: CustomFile[];
}

function getFilePathFromUrl() {
    // Retrieve file path after page anchor.
    return window.location.hash.slice(1);
}

function goToUrl(url: string): void {
    window.location.href = url;
}

function onHistoryChange(callback: (this: WindowEventHandlers, ev: PopStateEvent) => any): void {
    window.onpopstate = callback;
}

function pushUrlInHistory(url: string): void {
    window.history.pushState({}, '', url);
}

class Repository {
    goBackButton: HTMLButtonElement;
    currentFilePathText: HTMLElement;
    childFileList: HTMLElement;
    fileContentBlock: HTMLElement;
    fileDescriptionBlock: HTMLElement;
    fileDescriptionText: HTMLElement;

    currentFile: CustomFile | null;

    constructor() {
        this.goBackButton = document.querySelector('#js_goBackButton') as HTMLButtonElement;
        this.currentFilePathText = document.querySelector('#js_currentFilePathText') as HTMLElement;
        this.childFileList = document.querySelector('#js_childFileList') as HTMLElement;
        this.fileContentBlock = document.querySelector('#js_fileContentBlock') as HTMLElement;
        this.fileDescriptionBlock = document.querySelector('#js_fileDescriptionBlock') as HTMLElement;
        this.fileDescriptionText = document.querySelector('#js_fileDescriptionText') as HTMLElement;

        this.currentFile = null;

        this.handleClickOnGoBackButton();
        this.loadFilePathFromUrl();
    }

    private handleClickOnGoBackButton() {
        this.goBackButton.addEventListener('click', () => {
            this.goToFilePath(this.currentFile?.relativeParentPath ?? '');
        });
    }

    public loadFilePathFromUrl(): void {
        this.loadFilePath(getFilePathFromUrl());
    }

    private async loadFilePath(path: string): Promise<void> {
        const response = await (await fetch(REPOSITORY_FILE_URL + path)).json();

        this.currentFile = response.file;
        this.updateGui(response.file);
    }

    private updateGui(file: CustomFile): void {
        this.prepareUpdate();
        this.showFilePath(file);

        if (file.isDir) {
            this.showChildFileList(file);
        } else {
            this.showFileContent(file);
        }

        if (file.description) {
            this.showFileDescription(file);
        }
    }

    private prepareUpdate(): void {
        this.childFileList.classList.add('d-none');
        this.fileContentBlock.classList.add('d-none');
        this.fileDescriptionBlock.classList.add('d-none');
    }

    private showFilePath(file: CustomFile): void {
        this.currentFilePathText.innerHTML = file.relativePath;
    }

    private showChildFileList(file: CustomFile): void {
        this.childFileList.innerHTML = '';

        this.addChildFileListItems(file);

        this.childFileList.classList.remove('d-none');
    }

    private addChildFileListItems(parentFile: CustomFile): void {
        parentFile.childFiles.forEach((childFile: CustomFile) => {
            const item = document.createElement('li');

            this.setFileListItemText(item, childFile);
            this.handleClickOnListItem(item, childFile);

            this.childFileList.append(item);
        });
    }

    private setFileListItemText(item: HTMLElement, file: CustomFile): void {
        item.innerHTML = `<img src=${ this.getIconImage(file) } class="me-1" /> ${ file.name }`;

        item.classList.add('text-primary', 'list-none', 'mb-1');
        item.setAttribute('role', 'button');
    }

    private getIconImage(file: CustomFile): string {
        return file.isDir ? barrelImage : (file.isArchive ? dynamiteImage : beerImage);
    }

    private handleClickOnListItem(item: HTMLElement, file: CustomFile): void {
        item.addEventListener('click', () => {
            if (file.isArchive || file.isImage || file.isPdf) {
                goToUrl(file.storagePath);
                return;
            }

            this.goToFilePath(file.relativePath);
        });
    }

    private showFileContent(file: CustomFile): void {
        this.fileContentBlock.innerHTML =
            '<a href="' + file.storagePath + '" download="'
            + file.name + '" class="btn btn-brown font-duality mb-3">'
            + '<i class="bi-download"></i> Télécharger'
            + '</a>'
            + '<pre><code class="hljs">' + file.content + '</code></pre>';

        this.fileContentBlock.classList.remove('d-none');
    }

    private showFileDescription(file: CustomFile): void {
        this.fileDescriptionText.innerHTML = file.description.replace(/<currentDir>/g, file.storagePath);
        this.fileDescriptionBlock.classList.remove('d-none');
    }

    private goToFilePath(path: string): void {
        this.loadFilePath(path);

        pushUrlInHistory(REPOSITORY_URL + '#' + path);
    }
}

const repository: Repository = new Repository();

onHistoryChange(() => {
    repository.loadFilePathFromUrl();
});
