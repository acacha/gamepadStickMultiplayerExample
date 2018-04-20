<template>
    <div>
        <ul>
            <li v-for="user in users">{{ user.name }}</li>
        </ul>
        <p v-if="gamepad">Id: {{ gamepad.id }}</p>
        <div v-for="ball in balls" class="ball" v-key="ball.id" ></div>
    </div>
</template>

<style>
    .ball {
        position: absolute;
        left: calc(50vw - 25px);
        top: calc(50vh - 25px);
        background-color: red;
        width: 50px;
        height: 50px;
        border-radius: 25px;
    }
</style>

<script>
  export default {
    data() {
      return {
        gamepad: null,
        balls: [],
        users: []
      }
    },
    methods: {
      updateLoop() {
        let gp = navigator.getGamepads()[0]
        let left = (gp.axes[0] + 1) / 2 * (window.innerWidth - this.$refs.ball.offsetWidth)
        let right = (gp.axes[1] + 1) / 2 * (window.innerHeight - this.$refs.ball.offsetHeight)

        this.$refs.ball.style.left = left + "px";
        this.$refs.ball.style.top =  right + "px";

        if (gp.buttons[0].pressed) {
          document.body.style.backgroundColor = "red";
        } else {
          document.body.style.backgroundColor = "white";
        }

        requestAnimationFrame(this.updateLoop);

      }
    },
    mounted() {
      console.log('Mounted!!!')
      console.log(Echo)
      Echo.join('balls')
        .here((users) => {
          console.log('HERE!!!!!!!!!!')
          console.log(users)
          this.users = users
          window.addEventListener("gamepadconnected", (e) => {
            console.log('############### NEW GAMEPAD -> NEW BALL')
            axios.post('ball').then((response) => {
              console.log('OK')
            }).catch((error) => {
              console.log(error)
            })
            Echo.private('balls')
              .whisper('new_ball', {
                gamepad: e.gamepad
              });
            console.log('BALLS 2')
            console.log('New gamepad connected')
            console.log(e.gamepad.id)
//        this.$refs.ball.style.backgroundColor = "green"
//        this.gamepad = e.gamepad
//        this.updateLoop()
          });
        })
        .joining((user) => {
          console.log('JOINING!!!!!!!!!!')
          console.log(user.name)
          this.users.push(user)
        })
        .leaving((user) => {
          console.log('LEAVING!!!!!!!!!!')
          console.log(user.name)
          this.users.splice(this.users.indexOf(user),1)
        })
        .listen('NewBall', (e) => {
          console.log('NEW BALL RECEIVED!')
          console.log(e)
          this.balls.push(e.ball)
        });
    }
  }
</script>
