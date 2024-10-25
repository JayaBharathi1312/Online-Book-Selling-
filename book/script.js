document.querySelector('form').addEventListener('submit', (e) => {
  e.preventDefault(); // Prevent form submission

  // Get input values
  const name = document.getElementById('name').value;
  const password = document.getElementById('password').value;
  const email = document.getElementById('email').value;
  const phone = document.getElementById('phone').value;
  const sex = document.querySelector('input[name="sex"]:checked')?.value;
  const dob = document.getElementById('dob').value; // Changed to single date input
  const languages = Array.from(document.querySelectorAll('input[name="languages"]:checked')).map((language) => language.value);
  const address = document.getElementById('address').value;

  // Validate input values
  if (name === '' || password === '' || email === '' || phone === '' || sex === undefined || dob === '' || languages.length === 0 || address === '') {
    alert('Please fill in all fields');
  } else if (!/^[a-zA-Z ]{6,}$/.test(name)) { // Name should be at least 6 characters long
    alert('Name can only contain alphabets and must be at least 6 characters long');
  } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
    alert('Invalid email address');
  } else if (password.length < 6) {
    alert('Password must be at least 6 characters long');
  } else if (phone.length !== 10 || !/^[0-9]*$/.test(phone)) {
    alert('Invalid phone number');
  } else {
    // Form submission successful
    alert('Registered successfully');
    // Here you can handle form submission, like sending data via AJAX
    // For example, you can use fetch() to submit the form data
    // fetch('connect.php', {
    //   method: 'POST',
    //   body: new URLSearchParams(new FormData(document.querySelector('form')))
    // })
    // .then(response => response.text())
    // .then(result => console.log(result));
  }
});
