// Back to Home ................
const mybutton = document.getElementById("bt-top");

// Show or hide with animation
window.addEventListener("scroll", function () {
  if (
    document.body.scrollTop > 1000 ||
    document.documentElement.scrollTop > 1000
  ) {
    mybutton.classList.add("show");
  } else {
    mybutton.classList.remove("show");
  }
});

// Smooth scroll to top
mybutton.addEventListener("click", function (e) {
  e.preventDefault();
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});
// Back to Home ................

// Hero Slider ...................
document.addEventListener("DOMContentLoaded", function () {
  var swiper = new Swiper(".mySwiper", {
    direction: "horizontal",
    loop: true,

    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },

    breakpoints: {
      768: {},
    },
  });
});
// Hero Slider ...................

// blog Slider ...................
var swiper = new Swiper(".myBlogSwiper", {
  spaceBetween: 25,
  // centeredSlides: true,
  slidesPerView: 2,
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    200: {
      slidesPerView: 1,
    },
    999: {
      slidesPerView: 2,
    },
  },
});
// blog Slider ...................

// Gallery Quick View Modal.........
document.addEventListener("DOMContentLoaded", () => {
  const quickViewButtons = document.querySelectorAll(".quick-view-btn");
  const modal = document.getElementById("quickViewModal");
  const modalImage = document.getElementById("modalImage");
  const modalTitle = document.getElementById("modalTitle");
  const closeButton = document.querySelector(".close-button");

  quickViewButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault(); // Prevent default link behavior (e.g., navigating to #)

      // Get the parent image container
      const imageContainer = button.closest(".institution_gallery_content_img");
      const imageElement = imageContainer.querySelector("img");
      const titleElement = imageContainer.querySelector("h2");

      // Get data from the image element (full source and title)
      // Assuming 'data-full-src' exists on the img tag for the full image path
      const fullSrc = imageElement.getAttribute("data-full-src");
      // Get the title from the h2 tag within the card
      const title = titleElement.textContent;

      // Populate the modal
      modalImage.src = fullSrc;
      modalTitle.textContent = title;

      // Show the modal with animation
      // We set display to flex first, then add 'active' for the transition
      modal.style.display = "flex";
      requestAnimationFrame(() => {
        modal.classList.add("active");
      });
    });
  });

  // Function to close the modal
  const closeQuickViewModal = () => {
    modal.classList.remove("active");
    // Wait for the transition to complete before setting display to none
    modal.addEventListener(
      "transitionend",
      function handler() {
        if (!modal.classList.contains("active")) {
          modal.style.display = "none";
        }
        modal.removeEventListener("transitionend", handler);
      },
      { once: true }
    );
  };

  // Close the modal when the close button is clicked
  closeButton.addEventListener("click", closeQuickViewModal);

  // Close the modal when clicking outside the modal content
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      closeQuickViewModal();
    }
  });

  // Optional: Close modal with Escape key
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && modal.classList.contains("active")) {
      closeQuickViewModal();
    }
  });
});
// Gallery Quick View Modal.........

// Notice Board Slider JS Start........
const wrapper = document.getElementById("wrapper");
const noticeContent = document.getElementById("noticeContent");

// Clone content to enable infinite scroll
const clone = noticeContent.cloneNode(true);
wrapper.appendChild(clone);

let pos = 0;
let isPaused = false;
let speed = 0.4;

document.querySelector(".notice_slider").addEventListener("mouseenter", () => {
  isPaused = true;
});

document.querySelector(".notice_slider").addEventListener("mouseleave", () => {
  isPaused = false;
});

function scrollNotices() {
  if (!isPaused) {
    pos -= speed;
    if (pos <= -noticeContent.offsetHeight) {
      pos = 0;
    }
    wrapper.style.transform = `translateY(${pos}px)`;
  }
  requestAnimationFrame(scrollNotices);
}

scrollNotices();
// Notice Board Slider JS End........

// Notice Single page Functionality................
function viewPdf(fileUrl) {
  window.open(fileUrl, "_blank");
  return false;
}

// Function to generate PDF from the entire HTML table content (as a screenshot)
function generatePdfFromHtml() {
  const element = document.getElementById("noticeTableContent");

  html2canvas(element, {
    scale: 2, // Increase scale for better resolution in PDF
  })
    .then((canvas) => {
      const imgData = canvas.toDataURL("image/png");
      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF("p", "mm", "a4"); // 'p' for portrait, 'mm' for units, 'a4' for page size

      // Calculate dimensions to fit image to PDF width while maintaining aspect ratio
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      // Add the image to the PDF, setting x=0, y=0, and computed width/height
      pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
      pdf.save("full_notice_board.pdf");
    })
    .catch((error) => {
      console.error("Error generating PDF from table:", error);
      alert("Could not generate PDF from table. Please try again.");
    });
}
// Notice Single page Functionality................

// Pop-Up Message JS Start.....................
function showPopupMessage() {
  setTimeout(function () {
    const popup = document.getElementById("popup-message");
    const overlay = document.getElementById("popup-overlay");
    const closeBtn = document.getElementById("popup-close");

    if (popup && overlay && closeBtn) {
      popup.classList.add("show");
      overlay.classList.add("show");
      popup.style.display = "block";
      overlay.style.display = "block";

      function hidePopup() {
        popup.classList.add("hide");
        overlay.classList.add("hide");

        popup.addEventListener(
          "animationend",
          function () {
            popup.style.display = "none";
            popup.classList.remove("show", "hide");
          },
          { once: true }
        );

        overlay.addEventListener(
          "transitionend",
          function () {
            overlay.style.display = "none";
            overlay.classList.remove("show", "hide");
          },
          { once: true }
        );
      }

      closeBtn.addEventListener("click", hidePopup);

      // Outside click to close
      overlay.addEventListener("click", function (event) {
        // Ensure the click was *on* the overlay, not on the popup
        if (event.target === overlay) {
          hidePopup();
        }
      });
    }
  }, 3000);
}

window.addEventListener("DOMContentLoaded", showPopupMessage);
// Pop-Up Message JS End.....................
