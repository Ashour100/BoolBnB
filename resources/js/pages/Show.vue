<template>
    <div class="MyContainer container">
        <div>
            <div class="row mx-auto px-sm-1 px-md-5 w-100" v-if="apartment.visible">
                <div class="pics position-relative col-12 mx-sm-auto d-flex gap-1">
                    <img :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" class="w-50 rounded h-100" alt="">
                    <div class="otherPics w-50 h-100 d-flex flex-column flex-wrap gap-1">
                        <div v-for="pic,index in pictures" :key="'show-images' + index" class="image-wrapper">
                            <img v-show="isLoaded == true" :src="(pic.image.startsWith('https://')) ? pic.image : '../../storage/'+ pic.image" class="rounded element-fill">
                            <div v-if="isLoaded == false" class="d-flex justify-content-center align-items-center element-fill">
                                <Loader/>
                            </div>
                        </div>
                    </div>
                    <div class="price position-absolute px-2 py-1 bg-light rounded-pill">
                        <span v-if="apartment.available">{{apartment.price}}	&euro;</span>
                        <span v-else class="text-danger">Non Disponibile</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-7 mt-4">
                    <h1 class="text-primary">{{apartment.title}}</h1>
                    <span id="apartment_address" class="text-dark">{{apartment.address}}</span>
                    <hr>
                    <h3 class="text-primary">Descrizione</h3>
                    <p >{{apartment.description}}</p>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-7 mt-3">
                    <h3 class="text-primary">Dettagli</h3>
                    <Details :apartment="apartment"/>
                    <h3 class="mt-5 text-primary">Servizi</h3>
                    <Services :id="id"/>
                </div>
            </div>
        </div>
        <div class="row mx-auto px-1 px-md-5 w-100">
            <div class="col-12">
                <h3 class="text-primary">Mappa</h3>
            </div>
            <div class="col-12 position-relative">
                <div class="map" id="map" ref="mapRef"></div>
                <button class="btn btn-light position-absolute dark" @click="darkmode()"> <i class="fas fa-lightbulb"></i></button>
            </div>
        </div>
        <div class="row mx-auto px-2 px-md-5 w-100" v-if="apartment.visible">
            <div class="col-sm-12 col-md-8 col-lg-7 mt-4">
                <h3 class="text-primary">Contatta l'host</h3>
                <div class="hostCard my-4 w-100 d-flex justify-content-between align-items-center p-3 rounded bg-white shadow">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="rounded-circle" :src="((host.profile_picture) && (host.profile_picture.startsWith('https://'))) ? host.profile_picture : '../../storage/'+ host.profile_picture" :alt="host.id">
                        <h4 class="m-0 text-primary">{{host.first_name}} {{host.last_name}}</h4>
                    </div>
                    <button type="button" class="btn btn-outline-primary shadow-none host" @click="showMessage"><a class=" text-decoration-none" href="#message"> Contatta l'host</a></button>
                </div>
            </div>
        </div>
        <div v-if="showContact" class="contactContainer shadow border rounded my-4 mx-3 mx-md-5" id="message">
            <section id="contacts" class="col-12 mx-auto px-2">
                <div class="container-fluid">
                    <div
                        class="alert d-flex justify-content-between align-items-center"
                        :class="`alert-${type}`"
                        role="alert"
                        v-if="(alert && type !='success')"
                    >
                        <span v-if="alertMessage">{{ alertMessage }} </span>
                        <ul v-if="hasErrors" class="mb-0 pl-4">
                            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                        </ul>
                        <span @click="alert = !alert" class="h2 mb-0" role="button">&times;</span>
                    </div>
                    <div v-if="(alert && type =='success')">
                        {{showAlert()}}
                    </div>
                    <h2 class="h1-responsive font-weight-bold text-center my-4">Contattaci</h2>
                    <p class="text-center w-responsive mx-auto">
                        Hai qualche domanda? Non esitare a contattarci direttamente.
                        l'Host ti risponderà in poche ore per aiutarti.
                    </p>
                    <div class="row p-0 px-3 px-md-5">
                        <div class="col-md-12 mb-md-0 mb-5 p-0 ">
                            <div class="row p-0">
                                <div class="col-md-6 px-4">
                                    <div class="md-form mb-3">
                                        <input
                                            type="text"
                                            id="full_name"
                                            v-model="form.full_name"
                                            class="form-control border-info shadow-none"
                                            :class="{ 'is-invalid': errors.full_name }"
                                            placeholder="Il tuo nome"
                                        />
                                        <div v-if="errors.full_name" class="invalid-feedback">
                                            {{ errors.full_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 px-4 mb-3">
                                    <div class="md-form mb-0">
                                        <input
                                            type="text"
                                            id="email"
                                            v-model="form.email"
                                            class="form-control border-info shadow-none"
                                            :class="{ 'is-invalid': errors.email }"
                                            placeholder="La tua email"
                                        />
                                        <div v-if="errors.email" class="invalid-feedback">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-0">
                                <div class="col-md-12 px-4">
                                    <div class="md-form">
                                        <textarea
                                            type="text"
                                            id="text"
                                            v-model="form.text"
                                            rows="4"
                                            class="form-control border-info md-textarea shadow-none"
                                            :class="{ 'is-invalid': errors.text }"
                                            placeholder="Il tuo messaggio"></textarea>
                                        <div v-if="errors.text" class="invalid-feedback">
                                            {{ errors.text }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center my-3 p-0">
                                    <button class="btn btn-primary" @click="sendForm">
                                        Invia
                                    </button>
                                </div>
                                <div class="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <h1 class="text-center mt-5" v-if="apartment.visible == 0">L'appartamento non è visibile</h1>
    </div>
</template>
<script>
import Axios from 'axios';
import Details from '../components/Details.vue';
import Services from '../components/Services.vue';
import tt from '@tomtom-international/web-sdk-maps';
import { isEmpty } from "lodash";
import {APP_KEYMAPS} from "../key";
import Loader from "../components/Loader.vue";

export default {
    name:'Show',
    components:{
        Details,
        Services,
        Loader,
    },
    data(){
        return {
            id: this.$route.params.id,
            apartment:[],
            pictures:[],
            host:[],
            showContact: false,
            form: {
                full_name: "",
                email: "",
                text: "",
                apartment_id: this.$route.params.id,
            },
            errors: {},
            type: "",
            alert: false,
            alertMessage: "",
            mapStyle:"https://api.tomtom.com/style/1/style/22.2.1-9/?map=2/basic_street-light",
            isLoaded: false,
            userInfo:null,
        };
    },
    computed: {
        hasErrors() {
        // ! Ha errori se non è vuoto, se è vuoto non ha errori
        return !isEmpty(this.errors);
        },
    },
    methods:{
        initializeMap() {
            this.map = tt.map({
                key:APP_KEYMAPS ,
                container: this.$refs.mapRef,
                center: {lng: this.apartment.long , lat: this.apartment.lat},
                zoom: 8,
                minZoom: 4,
                style: this.mapStyle,
            })
            this.map.addControl(new tt.FullscreenControl(), 'top-left');
            this.map.addControl(new tt.NavigationControl(), 'top-left');
            let marker =new tt.Marker().setLngLat([this.apartment.long, this.apartment.lat]).addTo(this.map);
            this.map = Object.freeze(this.map)
        },
        getInfo(){
            this.isLoaded = false;
            Axios.get('/api/apartment/'+this.id)
            .then(response=>{
                this.apartment=response.data;
                console.log(this.apartment);
                this.getHost(this.apartment.user_id);
                this.initializeMap()
                this.setLoader();
            })
        },
        getpics(){
            Axios.get('/api/apartment/pictures/'+this.id)
            .then(response=>{
                this.pictures=response.data;
            })
        },
        getHost(id){
            Axios.get('/api/apartment/host/'+id)
            .then(response=>{
                this.host=response.data[0][0];
                console.log(this.host);
            })
        },
        setLoader(){
            setTimeout(() => {
                this.isLoaded = true;
            }, 1500);
        },
        validateForm() {
            // Validazione
            const errors = {}; // ! oggetto vuoto inizialmente
            if (!this.form.full_name.trim())
                errors.full_name = "Il nome non è valido.";
            if (!this.form.email.trim()) errors.email = "La mail è obbligatoria.";
            if (!this.form.text.trim())
                errors.text = "Il testo del messaggio è obbligatorio.";
            // Controllo che sia una mail e che sia valida usando le espressioni regolari
            if (
                this.form.email.trim() &&
                !this.form.email.match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                )
            )
                errors.email = "La mail non è valida";
            this.errors = errors;
            if (this.hasErrors) {
                this.alertMessage = "Sono presenti degli errori.";
                this.type = "danger";
                this.alert = true;
            }
            },
            sendForm() {
            // * Richiamo validateForm
            this.validateForm();
            // Controllo se ci sono errori
            if (!this.hasErrors) {
                // * Creo una variabile per recuperare i params
                // Posso usare anche lo spread
                const params = {
                ...this.form,
                };
                // * Chiamo axios in POST per mandare i dati e gli passo params
                // potrei passare direttamente this.form perchè i campi COINCIDONO
                axios
                .post("http://127.0.0.1:8000/api/message", params)
                .then((res) => {
                    console.log(res);
                    // Controllo se comunque mi arrivano errori DAL BACKEND
                    if (res.data.errors) {
                    // Prendo gli errori DA LARAVEL e li metto comunque dentro errors
                    const { full_name, email, text } = res.data.errors;
                    const errors = {};
                    if (full_name) errors.full_name = full_name[0];
                    if (email) errors.email = email[0];
                    if (text) errors.text = text[0];
                    this.errors = errors;
                    this.type = "danger";
                    this.alert = true;
                    } else {
                    this.form.full_name = "";
                    this.form.email = "";
                    this.form.text = "";
                    this.alertMessage = "Messaggio inviato con successo.";
                    this.alert = true;
                    this.type = "success";
                    }
                })
                .catch((err) => {
                    // console.error(err.response.status);
                    this.alertMessage =
                    "'Messaggio non inviato. Si è verificato un errore. Riprovare più tardi";
                    this.alert = true;
                    this.type = "danger";
                })
                .then(() => {
                    this.isLoading = false;
                });
            }
        },
        showAlert() {
            // Use sweetalert2
            this.$swal({
                icon: 'success',
                title: 'Messaggio inviato!',
            });
            this.alert = !this.alert
        },
        showMessage(){
            this.showContact = !this.showContact
            window.scrollTo(0, document.body.scrollHeight);
        },
        darkmode(){
            if(this.mapStyle=="https://api.tomtom.com/style/1/style/22.2.1-9/?map=2/basic_street-light"){
                this.mapStyle="https://api.tomtom.com/style/1/style/20.4.5-*/?map=basic_night&poi=poi_main";
            }
            else{
                this.mapStyle="https://api.tomtom.com/style/1/style/22.2.1-9/?map=2/basic_street-light"
            }
            this.initializeMap()
        },
        getUserInfo(){
             axios.get('http://127.0.0.1:8000/api/apartment/host/' + this.$userId)
                .then((result) => {
                    this.form.email = result.data[0][0].email;
                    this.form.full_name = result.data[0][0].first_name + ' ' + result.data[0][0].last_name;


                }).catch((error) => {
                    console.warn(error);
                })
        }
    },
    created(){
        this.getInfo();
        this.getpics();
        this.getUserInfo();
    }
}
</script>
<style lang="scss" scoped>
    @import 'resources/sass/_variables.scss';
    .MyContainer{
        // background-color: $light-dark-background;
        padding: 2rem 0;
    }
    #apartment_address{
        color: $light-grey;
    }
    @media (min-width: 992px){
        .MyContainer{
            padding: 2rem 10vw;
        }
    }
    .pics{
        height: 50vh;
        // width: 80vw;
        min-width: 455px;
        img, .otherPics img{
            object-fit: cover;
        }
        .otherPics{
            overflow-y: hidden;
            div.image-wrapper{
                width: 49.5%;
                height: 49%;
                .element-fill{
                    height: 100%;
                    width: 100%;
                }
            }
        }
    @media(max-width: 767.98px)  {
        .otherPics{
            div.image-wrapper{
                width: 99.5%;
                // img{
                // }
            }
            }
        .contactContainer{
            max-width: 90vw;
        }
        }
    @media(max-width: 1399.98px){
        .contactContainer{
            max-width: 70vw;
            margin: 0 auto;
        }
    }
        .otherPics::-webkit-scrollbar{
            height: 1.5vh;
        }
        .otherPics::-webkit-scrollbar-track {
            background: rgb(214, 214, 214);
            border-radius: 1rem;
        }
        .otherPics::-webkit-scrollbar-thumb {
            background-color: rgb(163, 163, 163) ;
            border-radius: 1rem;
            border: .15rem solid rgb(214, 214, 214);
        }
        .price{
            bottom: 0.3rem;
            left: 1rem;
        }
    }
    .hostCard{
        div{
            width: 17rem;
        }
        img{
            height: 5rem;
            width: 5rem;
            object-fit: cover;
        }
        h4{
            vertical-align: auto;
        }
        #contacts {
            background-color: #fff;
            border-radius: 20px;
        }
    }
.map {
    height: 370px;
    width: 100%;
}
.dark{
    top: 1rem;
    right: 1.5rem;
    width: 28.99px;
    height: 28.99px;
    display: flex;
    justify-content: center;
}
.host:hover a{
    color: white;
}
</style>
