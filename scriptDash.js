function updatePhoneNumber() {
    var newPhone = prompt("Enter your new phone number:");
    if (newPhone) {
        alert("Phone number updated to: " + newPhone);
        // Here you can send this to the PHP backend to update the number in the database.
    }
}
