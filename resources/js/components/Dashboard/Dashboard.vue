<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">Appointments</div>
      <div class="card-body">
        <table class="table table-striped table-hover table-sm align-middle">
          <thead>
            <tr>
              <th>Date</th>
              <th>Customer</th>
              <th>Agent</th>
              <th>Property</th>
              <th>Distance</th>
              <th>ETA</th>
              <th>Time to Leave Office</th>
              <th>Time to Return Office</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="event in appointments">
              <td>{{ event.date }}</td>
              <td>{{ event.customer_id }}</td>
              <td>{{ event.agent_id }}</td>
              <td>{{ event.property_id }}</td>
              <td>{{ event.distance }}</td>
              <td>{{ event.eta }}</td>
              <td>{{ event.departure }}</td>
              <td>{{ event.arrival }}</td>
              <td>
                <button class="btn btn-sm btn-info">Edit</button>
                <button class="btn btn-sm btn-danger">Remove</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      appointments: []
    };
  },
  methods: {
    async getAppointments(filters = {}){
      const response = await this.axios.get('/api/appointments', { query: filters });
      this.appointments = response.data;
    }
  },
  created(){
    this.getAppointments();
  }
}
</script>
