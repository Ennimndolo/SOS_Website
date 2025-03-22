const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('nav-links');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});
const container = document.querySelector('.feature-cards-container');

function scrollLeft() {
    container.scrollBy({
        left: -300, // Scroll 300px to the left
        behavior: 'smooth'
    });
}

function scrollRight() {
    container.scrollBy({
        left: 300, // Scroll 300px to the right
        behavior: 'smooth'
    });
}
const heroSection = document.getElementById('hero');

// Array of background images
const backgroundImages = [
    'https://via.placeholder.com/1200x800/ff7f7f/333333?text=Slide+1',
    'https://via.placeholder.com/1200x800/7f7fff/333333?text=Slide+2',
    'https://via.placeholder.com/1200x800/7fff7f/333333?text=Slide+3'
];

let currentImageIndex = 0;

// Function to change the background image
function changeBackground() {
    currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
    heroSection.style.backgroundImage = `url('${backgroundImages[currentImageIndex]}')`;
}

// Change background every 5 seconds
setInterval(changeBackground, 5000);

//show the available courses by clicking on the formal courses button
const button = document.getElementById('formal-btn');
const content = document.getElementById('courseList');

// declaring function
button.addEventListener('click', function(){
    content.style.display = 'block';
    content.style.display = 'flex';
    content.style.justifyContent = 'center';
    content.style.flexWrap = 'wrap';
    content.style.gap = '20px';
});

//show the available courses by clicking on the informal courses button
const button2 = document.getElementById('informal-btn');
const contentInformal = document.getElementById('courseList2');

// declaring function
button2.addEventListener('click', function(){
    contentInformal.style.display = 'block';
    contentInformal.style.display = 'flex';
    contentInformal.style.justifyContent = 'center';
    contentInformal.style.flexWrap = 'wrap';
    contentInformal.style.gap = '20px';
});
