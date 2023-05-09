 <template>
  <div class="text-center">
    <v-tooltip right>
      <template v-slot:activator="{ on }">
        <v-avatar
          size="130"
          @mouseenter="mouseEnter"
          @mouseleave="mouseLeave"
          v-on="on"
          to="teste"
        >
          <v-img :src="srcDefalt" :height="height" width="100"> </v-img>
        </v-avatar>
        <v-rating
          :value="calculatePoints(solver.id)"
          color="yellow accent-4"
          background-color="yellow accent-4"
          hover
          readonly
          medium
        ></v-rating>
      </template>

      <div class="d-flex flex-column align-baseline">
        <span class="headline text-h6">
          {{ solver.name }}
        </span>
        <span>
          {{ solver.profile.office }}
        </span>
      </div>
    </v-tooltip>
  </div>
</template>
 
 <script>
import { mapGetters } from "vuex";

export default {
  created() {
    if (!this.solver.profile.photo) {
      this.srcDefalt = require("@/assets/images/profile.png");
    } else {
      this.srcDefalt = this.solver.profile.photo;
    }
  },
  props: {
    solver: { type: Object, require: true },
  },
  data() {
    return {
      height: 150,
      active: false,
      srcDefalt: require("@/assets/images/profile.png"),
      rating: 2.5,
    };
  },
  computed: {
    ...mapGetters(["responses"]),
    responsesOfSolver() {
      return this.responses.filter((resp) => {
        return resp.created_by === this.solver.id;
      });
    },
  },
  watch: {
    active() {
      if (this.active) {
        this.height = 200;
      } else {
        this.height = 150;
      }
    },
  },
  methods: {
    mouseEnter() {
      this.active = !this.active;
    },
    mouseLeave() {
      this.active = !this.active;
    },
    calculatePoints(id) {
      let ratings = [];
      let result = 0;

      // filter solucionador atual e mount array com valores para calculo
      if (this.responsesOfSolver && this.responsesOfSolver.length > 0) {
        this.responsesOfSolver
          .filter((resp) => {
            return resp.created_by === id;
          })
          .map((item) => {
            if (item.rating > 0) {
              return ratings.push(parseFloat(item.rating));
            } else return [];
          });

        console.log("ratings", ratings.length);

        if (ratings.length >= 5) {
          result = ratings.reduce((acum, item) => {
            return (acum += item);
          }, 0);

          return result / ratings.length;
        } else {
          return result;
        }
      }
    },
  },
};
</script>
 