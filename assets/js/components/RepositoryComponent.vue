<template>
    <div class="container" v-if="currentFile">
        <div class="mb-4">
            <a class="mr-2" @click="setRouterPath(currentFile.relativeParentPath)">
                <img src="/images/repository/colt.png" class="rotate-hover-10" />
            </a>
            <span class="p-2 font-size-20 jumbotron">
                {{ currentFile.relativePath }}
            </span>
        </div>

        <div class="row" v-if="currentFile.isDir">
            <ul>
                <li v-for="(file, path) of currentFile.files" :key="path" class="list-none mb-1">
                    <img :src="'/images/repository/' + getIconName(file) + '.png'" :alt="getIconName(file)" />

                    <a :href="file.storagePath" data-lightbox="lightbox" v-if="file.isImage">
                        {{ file.name }}
                    </a>
                    <a :href="file.storagePath" :download="file.name" v-else-if="file.isArchive">
                        {{ file.name }}
                    </a>
                    <a href="javascript:" @click="setRouterPath(file.relativePath)" v-else>
                        {{ file.name }}
                    </a>
                </li>
            </ul>
        </div>

        <div v-else>
            <a :href="currentFile.storagePath" :download="currentFile.name"
               class="btn btn-brown font-duality mb-3">
                <i class="fa fa-download"></i> Télécharger
            </a>

            <img :src="currentFile.storagePath" :alt="currentFile.name"
                 class="img-fluid mx-auto d-block"
                 v-if="currentFile.isImage" />

            <iframe :src="currentFile.storagePath"
                    style="width:100%; height: 80vh" frameborder="0"
                    v-else-if="currentFile.isPdf">
            </iframe>

            <pre v-highlightjs v-else>
                <code :class="currentFile.extension">{{ currentFile.content }}</code>
            </pre>
        </div>

        <div v-if="currentFile.description">
            <hr />
            <div class="m-3" v-html="replaceStoragePath(currentFile.description)"></div>
        </div>
    </div>
</template>

<script>
    import VueRouter from 'vue-router';

    const router = new VueRouter({
        mode: 'history'
    });

    export default {
        router,

        props: {
            path: {
                type: String,
                required: false,
                default: ''
            }
        },

        data() {
            return {
                UrlPrefix: '/repository',
                FileUrl: '/repository-file',

                currentFile: null
            };
        },

        mounted() {
            this.loadPath(this.path);
        },

        methods: {
            loadPath(path) {
                fetch(this._getFileUrl(path))
                    .then((response) => response.json())
                    .then((data) => this.currentFile = data.currentFile);
            },

            _getFileUrl(path) {
                return this.FileUrl + '?p=' + path;
            },

            setRouterPath(path) {
                this.$router.push(this.UrlPrefix + path);

                this.loadPath(path);
            },

            getIconName(file) {
                if (file.isDir) {
                    return 'barrel';
                }

                if (file.isArchive) {
                    return 'dynamite';
                }

                return 'beer';
            },

            replaceStoragePath(text) {
                return text.replace(/<currentDir>/g, this.currentFile.storagePath);
            }
        }
    };
</script>

<style scoped>
    .rotate-hover-10:hover {
        transform: rotate(-10deg);
    }

    .list-none {
        list-style: none;
    }
</style>
