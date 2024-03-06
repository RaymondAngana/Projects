import { gsap } from "gsap"
import ScrollTrigger from "gsap/ScrollTrigger"
gsap.registerPlugin(ScrollTrigger);

export default {
	init() {
    // let sideBar = document.querySelector('.right-rail');
    // gsap.to(sideBar, {
    //   ease: "none",
    //   scrollTrigger: {
    //     trigger: sideBar,
    //     pin: true,
    //     pinSpacing: false,
    //     start: 'top 80px',
    //     end: 'bottom top',
    //   },
    // })
  },
  finalize() {
  },
};
