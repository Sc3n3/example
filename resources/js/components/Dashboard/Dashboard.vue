<template>
  <div class="container mt-4">
    <div class="card mb-4">
      <div class="card-header">Filters</div>
      <div class="card-body">
        <div class="row">
          <div class="col-4 form-item">
            <label class="form-label">Creator</label>
            <select v-model="query.creator_id" class="form-control form-select" required="">
              <option v-for="agent in agents" :value="agent.id" v-html="agent.name"></option>
            </select>
          </div>
          <div class="col-4 form-item">
            <label class="form-label">Start Date</label>
            <date-picker v-model="query.start_date" type="datetime" valueType="YYYY-MM-DD HH:mm:ss"></date-picker>
          </div>
          <div class="col-4 form-item">
            <label class="form-label">End Date</label>
            <date-picker v-model="query.end_date" type="datetime" valueType="YYYY-MM-DD HH:mm:ss"></date-picker>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">Appointments</div>
      <div class="card-body">
        <table class="table table-striped table-hover align-middle text-center">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Status</th>
              <th scope="col">Date</th>
              <th scope="col">Contact</th>
              <th scope="col">Agent</th>
              <th scope="col">Office</th>
              <th scope="col">Property</th>
              <th scope="col">Distance</th>
              <th scope="col">ETA</th>
              <th scope="col">Time to Leave Office</th>
              <th scope="col">Time to Return Office</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody v-if="appointments.length">
            <tr v-for="event in appointments">
              <th scope="row">{{ event.id }}</th>
              <td class="text-center">
                <span v-if="isValid(event.date)" class="badge rounded-circle bg-success">&nbsp;</span>
                <span v-if="!isValid(event.date)" class="badge rounded-circle bg-danger">&nbsp;</span>
              </td>
              <td>{{ event.date }}</td>
              <td>
                <span v-if="event.contact">{{ event.contact.name }} ({{ event.contact.phone }})</span>
              </td>
              <td>
                <span v-if="event.agent">{{ event.agent.name }}</span>
              </td>
              <td>
                <span v-if="event.office">{{ event.office.name }}</span>
              </td>
              <td>
                <span v-if="event.property">{{ event.property.name }} ({{event.property.zip}})</span>
              </td>
              <td>{{ convertDistance(event.distance) }}</td>
              <td>{{ convertDuration(event.eta) }}</td>
              <td>{{ event.departure }}</td>
              <td>{{ event.arrival }}</td>
              <td>
                <button @click="edit(event)" class="btn btn-sm btn-info">Edit</button>
                <button @click="remove(event)" class="btn btn-sm btn-danger">Remove</button>
              </td>
            </tr>
          </tbody>
          <tbody v-else="">
            <tr>
              <td colspan="12" class="text-center">No appointments available.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    data(){
      return {
        query: {
          creator_id: null,
          start_date: null,
          end_date: null
        },
        order: {
          date: 'asc'
        },
        agents: [],
        appointments: [],
      };
    },
    methods: {
      async getAppointments(filters = {}, sort = {}){
        const order = Object.fromEntries(Object.entries(sort).map(([key, value]) => ['order['+ key +']', value]));
        const query = Object.fromEntries(Object.entries(filters).map(([key, value]) => ['query['+ key +']', value]));

        const response = await this.axios.get('/api/appointments', { params: { ...query, ...order } });
        this.appointments = response.data;
      },
      isValid(date){
        return this.$moment().isSameOrBefore(date);
      },
      remove(event){
        if (confirm('Are you sure want to delete?')) {
          this.axios.delete('/api/appointments/'+ event.id).then((resp) => {
            this.$toast.success(resp.data.message);
            this.getAppointments(this.query, this.order);
          }).catch((err) => {
            this.$toast.error('Appointment could not deleted.');
          });
        }
      },
      edit(event){
        this.$router.push({ name: 'update', params: { id: event.id }});
      },
      convertDistance(distance){
        return (distance / 1000).toFixed(1) + ' km(s)';
      },
      convertDuration(duration){
        return Math.ceil((duration / 60)) +' min(s)';
      }
    },
    watch: {
      query: {
        handler: function(val, old){
          this.getAppointments(this.query, this.order);
        },
        deep: true
      }
    },
    async created(){
      const agents = await this.axios.get('/api/agents');
      this.agents = agents.data;
    },
    mounted(){
      (function getAppointments(app){
        if (app.$root.auth.user) {
          app.query = { ...app.query, creator_id: app.$root.auth.user.id, start_date: app.$moment().format('YYYY-MM-DD HH:mm:00') };
        } else {
          setTimeout(() => getAppointments(app), 1000)
        }
      })(this);
    }
  }
</script>
