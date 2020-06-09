<template>
  <div>
    <select class="form-control" @change="changeMonth($event.target.value)">
      <option
        v-for="month in range(new Date().getMonth(), 12)"
        :key="month"
        :value="month"
      >{{ `${monthNames[month]} 2020`}}</option>
    </select>
    <hr />
    <ul class="list-group list-group-flush">
      <li
        class="list-group-item"
        v-for="(date, index) in dates"
        :id="date.id"
        :key="index"
      >{{ `${date.date.getDate()} ${new Intl.DateTimeFormat("en-US", { weekday: "short" }).format(date.date)}` }}</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "CalendarDates",
  props: ["dates"],
  data() {
    return {
      monthNames: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      ]
    };
  },
  methods: {
    *range(start = 0, end = null, step = 1) {
      if (end == null) {
        end = start;
        start = 0;
      }

      for (let i = start; i < end; i += step) {
        yield i;
      }
    },
    changeMonth(month){
      this.$emit('change-month', month)
    },
    markEvents(selectedDates) {
      this.dates
        .filter(date =>
          selectedDates.find(
            selectedDate => date.date.getTime() === selectedDate.getTime()
          )
        )
        .forEach(date => {
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
    }
  }
};
</script>