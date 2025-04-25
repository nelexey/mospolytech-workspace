const likeButton = document.getElementById('likeButton');

function handleLikeClick() {
  this.classList.toggle('active');
}

likeButton.addEventListener('click', handleLikeClick);

const likeButton2 = document.getElementById('likeButton2');
const dislikeButton = document.getElementById('dislikeButton');

function handleRatingClick() {
  if (this.classList.contains('active')) {
    this.classList.remove('active');
  } else {
    likeButton2.classList.remove('active');
    dislikeButton.classList.remove('active');
    this.classList.add('active');
  }
}

likeButton2.addEventListener('click', handleRatingClick);
dislikeButton.addEventListener('click', handleRatingClick);

const cartCount = document.getElementById('cartCount');
const addToCartButtons = document.querySelectorAll('.add-to-cart');

function addToCart() {
  let count = parseInt(cartCount.textContent);
  count += 1;
  cartCount.textContent = count;
}

addToCartButtons.forEach(button => {
  button.addEventListener('click', addToCart);
});

const sortAscButton = document.getElementById('sortAsc');
const sortDescButton = document.getElementById('sortDesc');
const sortResetButton = document.getElementById('sortReset');
const numbersListContainer = document.getElementById('numbersList');

const originalNumbers = [];
for (let i = 0; i < 10; i++) {
  originalNumbers.push(Math.floor(Math.random() * 100));
}

let currentNumbers = [...originalNumbers];
let ulElement = document.createElement('ul');

function displayNumbers(numbers) {
  while (ulElement.firstChild) {
    ulElement.removeChild(ulElement.firstChild);
  }
  
  numbers.forEach(number => {
    const liElement = document.createElement('li');
    liElement.textContent = number;
    ulElement.appendChild(liElement);
  });
  
  if (!numbersListContainer.contains(ulElement)) {
    numbersListContainer.appendChild(ulElement);
  }
}

displayNumbers(originalNumbers);

function sortAscending() {
  currentNumbers = [...originalNumbers].sort((a, b) => a - b);
  displayNumbers(currentNumbers);
}

function sortDescending() {
  currentNumbers = [...originalNumbers].sort((a, b) => b - a);
  displayNumbers(currentNumbers);
}

function resetSort() {
  currentNumbers = [...originalNumbers];
  displayNumbers(currentNumbers);
}

sortAscButton.addEventListener('click', sortAscending);
sortDescButton.addEventListener('click', sortDescending);
sortResetButton.addEventListener('click', resetSort);

const coordinatesDiv = document.getElementById('coordinates');

function showCoordinates(event) {
  const x = event.clientX;
  const y = event.clientY;
  const element = event.target.tagName.toLowerCase();
  
  coordinatesDiv.textContent = `X: ${x}, Y: ${y} - ${element}`;
}

document.addEventListener('pointerdown', showCoordinates);