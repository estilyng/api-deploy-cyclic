 <template>
  <div>
    <component :is="dashboardComponent"></component>
    <!-- <div v-for="(item, i) in componentSelected" :key="i">{{ item.name }}</div> -->
  </div>
</template>
 
 <script>
import HomeAdmin from "./HomeAdmin";
import HomeOperator from "./HomeOperator";
// import HomeSolver from "./HomeSolver";

import localforage from "localforage";

const RoleDashboardMapping = {
  administrador: HomeAdmin,
  direcionador: HomeAdmin,
  solucionador: HomeAdmin,
  operador: HomeOperator,
};
export default {
  created() {
    localforage.getItem("helpDesk").then((value) => {
      this.componentSelected = value.login.auth.roles.map((item) => {
        return (this.componentSelected = item);
      });
    });
  },
  data() {
    return {
      componentSelected: null,
    };
  },
  computed: {
    dashboardComponent() {
      let component = "";
      for (const key in this.componentSelected) {
        component = this.componentSelected[key].name;
      }
      return RoleDashboardMapping[component];
    },
  },
};
</script>
 
 <style>
</style>