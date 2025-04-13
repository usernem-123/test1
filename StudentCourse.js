function submitUserForm(){
    const fullName = document.getElementById('fullName').value;
    const idNumber = document.getElementById('idNumber').value;
    const courses = document.getElementById('courses').value;
    const yearLevel = document.getElementById('yearLevel').value;
  
    // Here you can add your logic to send this data to your server
    console.log("User  Data:", { fullName, idNumber, courses, yearLevel });
  
    // Close the modal after submission
    $('#addUser Modal').modal('hide');
  
    // Optionally, reset the form
    document.getElementById('addUser Form').reset();
  }

const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');

    toggleSidebar.addEventListener('click', function () {
      sidebar.classList.toggle('open');
      content.classList.toggle('open');
    });

    toggleSidebarMobile.addEventListener('click', function () {
      sidebar.classList.toggle('open');
      content.classList.toggle('open');
    });
    
    document.addEventListener("DOMContentLoaded", function () {
      const usernameInput = document.getElementById("username");
      const qrImage = document.getElementById("qrImage");
    
      usernameInput.addEventListener("input", function () {
        const username = usernameInput.value.trim();
        if (username !== "") {
          const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${encodeURIComponent(username)}`;
          qrImage.src = qrUrl;
          qrImage.style.display = "block";
        } else {
          qrImage.style.display = "none";
        }
      });
    });
    