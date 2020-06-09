<template>
  <div>
    <card title="Calendar">
      <div class="row">
        <!-- form -->
        <div class="col-md-4">
          <form @submit="saveEvent">
            <div class="form-group">
              <label>Event</label>
              <input type="text" class="form-control" v-model="form.event" />
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>From</label>
                <input type="date" class="form-control" v-model="form.fromDate" />
              </div>
              <div class="form-group col-md-6">
                <label>To</label>
                <input type="date" class="form-control" v-model="form.toDate" />
              </div>
            </div>
            <div class="form-row">
              <div class="col" v-for="(day,index) in days" :key="index">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="form.selectedDays"
                    :value="day"
                  />
                  <label class="form-check-label">{{ day }}</label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
        <!-- date -->
        <div class="col-md-8">
          <h2>Jun 2020</h2>
          <hr />
          <ul class="list-group list-group-flush">
            <li
              class="list-group-item"
              v-for="(date, index) in dates"
              :id="date.id"
              :key="index"
            >{{ `${date.date.getDate()} ${getNameOfDay(date.date)}` }}</li>
          </ul>
        </div>
      </div>
    </card>
  </div>
</template>

<script>
import Card from "./Card";
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "Calendar",
  data() {
    return {
      dates: [],
      form: {
        event: null,
        fromDate: null,
        toDate: null,
        selectedDays: []
      },
      days: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
    };
  },
  created() {
    this.dates = this.getDates(6, 2020);
  },
  async mounted() {
    const events = await axios
      .get("/api/event")
      .then(response =>
        response.data.map(
          data => new Date(new Date(data.date).setHours(0, 0, 0, 0))
        )
      );

    this.markEvents(events);
  },
  methods: {
    getDates(month, year) {
      return new Array(31)
        .fill("")
        .map((v, i) => {
          return {
            id: `june-${i + 1}`,
            date: new Date(year, month - 1, i + 1),
            selected: false
          };
        })
        .filter(v => v.date.getMonth() === month - 1);
    },
    getNameOfDay(day) {
      return new Intl.DateTimeFormat("en-US", { weekday: "short" }).format(day);
    },
    getDateRange(start, end) {
      let dates = [];
      const endDate = new Date(end);

      for (
        const d = new Date(start);
        d <= endDate;
        d.setDate(d.getDate() + 1)
      ) {
        const date = new Date(d);
        date.setHours(0, 0, 0, 0);
        dates.push(date);
      }

      return dates;
    },
    notif(title, icon = "success") {
      Swal.fire({
        icon: icon,
        title: title,
        toast: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 3000
      });
    },
    mapDateData(selectedDates) {
      /**
       * Compute the offset because toISOString() converts it to UTC.
       * There is a chance that the given day will become -1 day when converted to ISO
       * so we need to compute the offset
       */
      return selectedDates.map(date => {
        const tzoffset = date.getTimezoneOffset() * 60000; //offset in milliseconds
        const localISOTime = new Date(date - tzoffset)
          .toISOString()
          .slice(0, 10);
        return localISOTime;
      });
    },
    markEvents(selectedDates) {
      selectedDates.forEach(selectedDate => {
        const date = this.dates.find(
          date => date.date.getTime() === selectedDate.getTime()
        );
        document
          .getElementById(date.id)
          .classList.add("list-group-item-success");
      });
    },
    clearEvents() {
      this.dates.forEach(date =>
        document
          .getElementById(date.id)
          .classList.remove("list-group-item-success")
      );
    },
    saveEvent(e) {
      e.preventDefault();

      let selectedDates = this.getDateRange(
        this.form.fromDate,
        this.form.toDate
      ).filter(date =>
        this.form.selectedDays.includes(this.getNameOfDay(date))
      );

      axios
        .post("/api/event", {
          date: this.mapDateData(selectedDates)
        })
        .then(response => {
          this.clearEvents();
          this.markEvents(selectedDates);
          this.notif("Event successfully saved");
        })
        .catch(error => {
          this.notif("Something went wrong", "error");
        });
    }
  }
};
</script>