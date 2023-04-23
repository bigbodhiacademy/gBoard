document.querySelectorAll(".stars").forEach((starsWrapper) => {
    starsWrapper.addEventListener("click", (event) => {
      if (event.target.tagName === "LABEL") {
        const starIndex = Array.from(starsWrapper.children).indexOf(event.target);
        const input = starsWrapper.previousElementSibling;
        input.value = 5 - starIndex;
      }
    });
  });
  

  