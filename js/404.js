console.clear();

const star = document.getElementsByClassName("n-star");
const gl = document.getElementsByClassName("s-gls");

////Morning

function morning() {
  const morningTl = gsap.timeline({ ease: "linear" });
  const mdura = 7;

  morningTl
    .to(
      "#morning",
      {
        opacity: 1,
        duration: 0
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 0,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      0
    )
    .to(
      "#m-m1",
      {
        x: 70,
        duration: mdura
      },
      0
    )
    .to(
      "#m-m2",
      {
        x: 50,
        duration: mdura
      },
      0
    )
    .to(
      "#m-m3",
      {
        x: 35,
        duration: mdura
      },
      0
    )
    .to(
      "#m-m4",
      {
        x: 20,
        duration: mdura
      },
      0
    )
    .to(
      "#m-m5",
      {
        x: 20,
        duration: mdura
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 23,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      5
    )
    .to(
      "#morning",
      {
        opacity: 0,
        duration: 0
      },
      7
    );

  return morningTl;
}

///Sunset

function sunset() {
  const sunsetTl = gsap.timeline({ ease: "linear" });
  const sdura = 10;

  gsap.to(gl, {
    x: 8,
    stagger: {
      each: 0.1,
      from: "random",
      repeat: -1,
      yoyo: true
    },
    duration: 2,
    ease: "power1.inOut"
  });

  gsap.to(".s-bw2", {
    rotate: 25,
    transformOrigin: "right bottom",
    repeat: -1,
    yoyo: true,
    ease: "power1.inOut",
    duration: 1
  });
  gsap.to(".s-bw1", {
    rotate: -25,
    transformOrigin: "left bottom",
    repeat: -1,
    yoyo: true,
    ease: "power1.inOut",
    duration: 1
  });

  sunsetTl
    .to(
      "#sunset",
      {
        opacity: 1,
        duration: 0
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 0,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      0
    )
    .to(
      "#s-ml2",
      {
        x: 30,
        duration: sdura
      },
      0
    )
    .to(
      "#s-ml1",
      {
        x: 20,
        duration: sdura
      },
      0
    )
    .to(
      "#s-ml3",
      {
        x: 5,
        duration: sdura
      },
      0
    )
    .to(
      "#s-m2",
      {
        x: 50,
        duration: sdura
      },
      0
    )
    .to(
      "#s-m1",
      {
        x: 40,
        duration: sdura
      },
      0
    )
    .to(
      "#s-y",
      {
        x: 40,
        duration: sdura
      },
      0
    )
    .to(
      "#s-b1",
      {
        x: 20,
        duration: sdura
      },
      0
    )
    .to(
      "#s-b2",
      {
        x: 20,
        duration: sdura
      },
      0
    )
    .to(
      "#s-c1",
      {
        x: 40,
        duration: sdura
      },
      0
    )
    .to(
      "#s-c2",
      {
        x: 30,
        duration: sdura
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 23,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      5
    )
    .to(
      "#sunset",
      {
        opacity: 0,
        duration: 0
      },
      7
    );

  return sunsetTl;
}

///NIGHT

function night() {
  const nightTl = gsap.timeline({ ease: "linear" });
  const ndura = 7;

  gsap.to(star, {
    scale: 0.3,
    transformOrigin: "center",
    stagger: {
      each: 0.1,
      from: "random",
      repeat: -1,
      yoyo: true
    },
    duration: 0.6,
    ease: "power1.inOut"
  });

  gsap.set("#n-l1", {
    y: -20
  });

  gsap.set("#n-l2", {
    y: -40
  });

  gsap
    .to("#n-l1, #n-l2, #n-l3, #n-l4", {
      rotate: 40,
      transformOrigin: "center bottom",
      stagger: {
        each: 1,
        from: "random",
        repeat: -1,
        yoyo: true
      },
      duration: 3,
      ease: "power1.inOut"
    })
    .seek(100);

  nightTl
    .to(
      "#night",
      {
        opacity: 1,
        duration: 0
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 0,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      0
    )
    .to(
      "#n-stars",
      {
        x: 10,
        duration: ndura
      },
      0
    )
    .to(
      "#n-city",
      {
        x: 60,
        duration: ndura
      },
      0
    )
    .to(
      "#window-b",
      {
        scaleY: 23,
        transformOrigin: "top",
        duration: 2,
        ease: "power2.out"
      },
      5
    );
  // .to(
  //   "#night",
  //   {
  //     opacity: 0,
  //     duration: 0
  //   },
  //   7
  // );

  return nightTl;
}

///window

gsap.set("#window-b", {
  scaleY: 23,
  transformOrigin: "top"
});

///Master

const master = gsap.timeline({ repeat: -1 });

master.add(morning()).add(sunset(), 7).add(night(), 14);
