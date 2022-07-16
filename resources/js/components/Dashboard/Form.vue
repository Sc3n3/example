<template>
  <div class="container bg-white py-4">
    <form class="form" @submit.prevent="">
      <div class="card">
        <div class="card-header">
          Customer Details
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-4 form-item">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" />
            </div>
            <div class="col-4 form-item">
              <label class="form-label">Phone Number</label>
              <input type="text" class="form-control" />
            </div>
            <div class="col-4 form-item">
              <label class="form-label">Email Address</label>
              <input type="text" class="form-control" />
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3 mb-4">
        <div class="col-3">
          <div class="card">
            <div class="card-header">
              Event Details
            </div>
            <div class="card-body">
              <div class="form-item mb-3">
                <label class="form-label">Event Date</label>
                <input v-model="form.date" class="form-control" type="text" />
              </div>
              <div class="form-item mb-2">
                <label class="form-label">Which office do you want to start?</label>
                <select v-model="from" class="form-control">
                  <option v-for="office in offices" :value="office" v-html="office.name"></option>
                </select>
              </div>
              <div class="form-item">
                <label class="form-label">ETA</label>
                <input v-bind="eta" class="form-control" type="text" readonly="readonly" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-9">
          <div class="card">
            <div class="card-header">
              Property Details
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-3 form-item">
                  <label class="form-label">Property Name</label>
                  <input v-model="to.name" class="form-control" type="text" />
                </div>
                <div class="col-3 form-item">
                  <label class="form-label">Property Zip</label>
                  <input v-model="to.zip" class="form-control" type="text" />
                </div>
                <div class="col-3 form-item">
                  <label class="form-label">Property Latitude</label>
                  <input v-model="to.latitude" class="form-control" type="text" />
                </div>
                <div class="col-3 form-item">
                  <label class="form-label">Property Longitude</label>
                  <input v-model="to.longitude" class="form-control" type="text" />
                </div>
              </div>
              <div class="form-item">
                <label class="form-label">Property Address</label>
                <textarea v-model="to.address" class="form-control" rows="4" style="resize:none" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <google-map style="height:25vw" @click="marker" @mouseover="mouseOver" ref="map"></google-map>

    </form>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        offices: [],
        from: null,
        to: {
          zip: null,
          latitude: null,
          longitude: null,
          address: null
        },
        form: {
          name: null,
          email: null,
          phone: null,
          date: null
        }
      }
    },
    methods: {
      marker(e){
        console.log('marker', this.from);
      },
      mouseOver(e){
        console.log('mouseOver', this.from);
      },
      changeFrom(){

      },
      changeTo()
      {

      }
    },
    async created(){
      const response = await this.axios.get('/api/offices');
      this.offices = response.data;
      this.from = response.data[0];
    }
  }
</script>