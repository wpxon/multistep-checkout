window.onload = () => {
  const steps = Array.from(document.querySelectorAll(".one-page-checkout .step"));
  const nextBtn = document.querySelectorAll(".one-page-checkout .next-btn");
  const prevBtn = document.querySelectorAll(".one-page-checkout .prev-btn");
  const form = document.querySelector(".one-page-checkout");
  console.log(steps);

  steps.forEach((item, index)=>{ 
    if( 0 == index ){
      document.querySelector(".one-page-checkout .step").classList.add("active");;
      document.querySelector(".prev-btn").remove();
    } 
  });

  nextBtn.forEach((button) => {
    button.addEventListener("click", e => {
      e.preventDefault();
      changeStep("next");
    });
  });
  prevBtn.forEach((button) => {
    button.addEventListener("click", e => {
      e.preventDefault();
      changeStep("prev");
    });
  });
 
  function changeStep(btn) {
    let index = 0;
    const active = document.querySelector(".one-page-checkout .step.active"); 
    index = steps.indexOf(active);
    steps[index].classList.remove("active");  
    if (btn === "next") {
      index++;
    } else if (btn === "prev") {
      index--;
    }
    steps[index].classList.add("active"); 
  }

}