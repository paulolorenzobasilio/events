<template>
  <div>
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
  methods: {
    markEvents(selectedDates) {
      this.dates.filter(date =>
        selectedDates.find(
          selectedDate => date.date.getTime() === selectedDate.getTime()
        )
      ).forEach(date => {
        document.getElementById(date.id).classList.add("list-group-item-success");
      })
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