<template>
  <div class="container bg-white py-4">
    <form class="form" @submit.prevent="submit">
      <div class="row">
        <div class="col-7">
          <div class="card">
            <div class="card-header">
              Customer Details
            </div>
            <div class="card-body">
              <div class="row justify-content-center">
                <div class="col-4 form-item">
                  <label class="form-label">Full Name</label>
                  <input v-model="form.contact.name" type="text" class="form-control" required="" />
                </div>
                <div class="col-4 form-item">
                  <label class="form-label">Phone Number</label>
                  <input v-model="form.contact.phone" type="text" class="form-control" required="" />
                </div>
                <div class="col-4 form-item">
                  <label class="form-label">Email Address</label>
                  <input v-model="form.contact.email" type="text" class="form-control" required="" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-5">
          <div class="card">
            <div class="card-header">
              Property Details
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-6 form-item">
                  <label class="form-label">Property Name</label>
                  <input v-model="to.name" class="form-control" type="text" required="" />
                </div>
                <div class="col-6 form-item">
                  <label class="form-label">Property Zip</label>
                  <input v-model="to.zip" class="form-control" type="text" required="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">
          Event Details
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-4 form-item">
              <label class="form-label">Event Date</label>
              <date-picker v-model="form.date" type="datetime" valueType="YYYY-MM-DD HH:mm:ss"></date-picker>
            </div>
            <div class="col-4 form-item">
              <label class="form-label">Agent</label>
              <select v-model="agent" class="form-control form-select" required="">
                <option v-for="agent in agents" :value="agent" v-html="agent.name"></option>
              </select>
            </div>
            <div class="col-4 form-item">
              <label class="form-label">Starting Office</label>
              <select v-model="from" class="form-control form-select" required="">
                <option v-for="office in offices" :value="office" v-html="office.name"></option>
              </select>
            </div>
            <div class="col-12 mt-3"></div>
            <div class="col-3 form-item">
              <label class="form-label">ETA</label>
              <input :value="etaFormatted" class="form-control" type="text" readonly="readonly" />
            </div>
            <div class="col-3 form-item">
              <label class="form-label">Distance</label>
              <input :value="distanceFormatted" class="form-control" type="text" readonly="readonly" />
            </div>
            <div class="col-3 form-item">
              <label class="form-label">Office Departure Time</label>
              <input :value="form.departure" class="form-control" type="text" readonly="readonly" />
            </div>
            <div class="col-3 form-item">
              <label class="form-label">Office Arrival Time</label>
              <input :value="form.arrival" class="form-control" type="text" readonly="readonly" />
            </div>
          </div>
        </div>
      </div>

      <google-map class="mt-4" style="height:35vw" :center="map.center" :zoom="map.zoom" @rightclick="marker" ref="map">
        <google-map-directions v-if="isToValid && isFromValid" :origin="originCoordinates" :destination="destinationCoordinates" preserve-viewport></google-map-directions>
      </google-map>

      <div class="w-100 text-end mt-4">
        <button class="btn btn-lg btn-success" type="submit">Save</button>
      </div>

    </form>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    data(){
      return {
        agents: [],
        offices: [],
        from: {
          id: null,
          name: null,
          zip: null,
          latitude: null,
          longitude: null,
          address: null
        },
        to: {
          id: null,
          name: null,
          zip: null,
          latitude: null,
          longitude: null,
          address: null
        },
        form: {
          id: null,
          contact: {
            id: null,
            name: null,
            email: null,
            phone: null
          },
          date: null,
          eta: null,
          distance: null,
          departure: null,
          arrival: null,
        },
        agent: {
          id: null,
          name: null
        },
        delay: null,
        map: {
          zoom: 5,
          center: {
            lat: 53.80917756087661,
            lng: -4.839354941476767
          }
        }
      }
    },
    computed: {
      isToValid(){
        return new Boolean((!!this.to.id || !!this.to.zip || this.to.latitude && this.to.longitude)).valueOf();
      },
      isFromValid(){
        return new Boolean((!!this.from.id || !!this.from.zip || this.from.latitude && this.from.longitude)).valueOf();
      },
      destinationCoordinates(){
        return [this.to.latitude, this.to.longitude].join(',');
      },
      originCoordinates(){
        return [this.from.latitude, this.from.longitude].join(',');
      },
      etaFormatted(){
        return Math.ceil(this.form.eta / 60) +' min(s)';
      },
      distanceFormatted(){
        return (this.form.distance / 1000).toFixed(1) + ' km(s)';
      }
    },
    methods: {
      marker(e){
        setTimeout(async () => {
          const zip = await this.getCoordinatesZip(e.latLng.lat(), e.latLng.lng());
          this.to = { ...this.to, zip: zip, latitude: e.latLng.lat(), longitude: e.latLng.lng() };
          console.log(this.to)
        }, 0);

        e.stop();
        return false;
      },
      async submit(){
        const data = {
          ...this.form,
          office_id: this.from.id,
          agent_id: this.agent.id,
          property: {
            name: this.to.name,
            zip: this.to.zip
          }
        };

        if (this.form.id) {
          let response = await this.axios.put('/api/appointments/'+ this.form.id, data);
        } else {
          let response = await this.axios.post('/api/appointments', data);
        }

        this.$toast.success(response.data.message);
        this.$router.push({ name: 'dashboard' });
      },
      updateDurations(){
        if (this.form.date && this.form.eta) {
          this.form.arrival = this.$moment(this.form.date).add((this.form.eta + (60 * 60)), 'second').format('YYYY-MM-DD HH:mm:ss');
          this.form.departure = this.$moment(this.form.date).subtract(this.form.eta, 'second').format('YYYY-MM-DD HH:mm:ss');
        }
      },
      getDistance(typing = true){
        clearTimeout(this.delay);
        if (this.isToValid && this.isFromValid) {
          this.delay = setTimeout(async () => {
            try {
              const response = await this.axios.post('/api/distance', { from: this.from, to: this.to });
              this.form.eta = response.data.duration;
              this.form.distance = response.data.distance;
              this.to = { ...this.to, ...response.data.destination };

              this.updateDurations();

              this.$refs.map.fitBounds(new window.google.maps.LatLngBounds({
                lat: response.data.bounds.southwest.latitude,
                lng: response.data.bounds.southwest.longitude
              }, {
                lat: response.data.bounds.northeast.latitude,
                lng: response.data.bounds.northeast.longitude
              }));

            } catch(e) {
              this.form.distance = null;
              this.form.eta = null;
            }
          }, (typing ? 1500 : 0));
        }
      },
      async getCoordinatesZip(latitude, longitude){
        const response = await this.axios.post('/api/location', {
          latitude: latitude,
          longitude: longitude
        });
        return response.data.zip;
      }
    },
    watch: {
      'from.id': function(val, old){
        this.getDistance();
      },
      'from.zip': function(val, old){
        this.getDistance();
      },
      'from.latitude': function(val, old){
        this.getDistance();
      },
      'from.longitude': function(val, old){
        this.getDistance();
      },
      'to.zip': function(val, old){
        this.getDistance();
      },
      'to.latitude': function(val, old){
        this.getDistance();
      },
      'to.longitude': function(val, old){
        this.getDistance();
      },
      'form.date': function(val, old){
        this.updateDurations();
      }
    },
    async created(){
      const offices = await this.axios.get('/api/offices');
      this.offices = offices.data;
      this.from = offices.data[0] || this.from;

      const agents = await this.axios.get('/api/agents');
      this.agents = agents.data;
      this.agent = agents.data[0] || this.form.agent_id;
    },
    async mounted(){
      if (this.$route.params.id) {
        const appointment = await this.axios.get('/api/appointments/'+ this.$route.params.id);
        this.to = appointment.data.property;
        this.from = appointment.data.office;
        this.form = {
          id: appointment.data.id,
          contact: appointment.data.contact,
          date: appointment.data.date,
          eta: appointment.data.eta,
          distance: appointment.data.distance,
          departure: appointment.data.departure,
          arrival: appointment.data.arrival
        };
      }
    }
  }
</script>

<style>
  .mx-datepicker {
    width: 100%;
  }
</style>