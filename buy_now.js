const products = [
    {
        id: 1,
        name: "Smartphone X100",
        price: "$799.99",
        desc: "Experience the latest technology with our powerful Smartphone X100.",
        img: "71n1OfJ92YL.jpg"
    },
    {
        id: 2,
        name: "Wireless Headphones Pro",
        price: "$199.99",
        desc: "Enjoy crystal clear sound with no wires to hold you back.",
        img: "shopping.webp"
    },
    {
        id: 3,
        name: "FitTrack Plus",
        price: "$129.99",
        desc: "Keep track of your health and fitness goals with this sleek tracker.",
        img: "download (1).jpeg"
    },
    {
        id: 4,
        name: "SmartWatch Ultra",
        price: "$349.99",
        desc: "Stay connected and stylish with the SmartWatch Ultra.",
        img: "download.jpeg"
    },
    {
        id: 5,
        name: "Laptop Pro 15",
        price: "$1,299.99",
        desc: "Ultra-fast performance, 15-inch display, powerful CPU and GPU for creators and gamers.",
        img: "shopping (1).webp"
    },
    {
        id: 6,
        name: "4K Camera Pro",
        price: "$899.99",
        desc: "Capture stunning images and videos with this 4K professional camera.",
        img: "download (2).jpeg"
    }
];

const params = new URLSearchParams(window.location.search);
const id = parseInt(params.get("id"));

const product = products.find(p => p.id === id);

if (!product) {
    alert("Product not found!");
    window.location.href = "products.html";
} else {
    document.getElementById("pd-name").innerText = product.name;
    document.getElementById("pd-price").innerText = product.price;
    document.getElementById("pd-desc").innerText = product.desc;
    document.getElementById("pd-img").src = product.img;
}

document.getElementById("btn-buy-confirm").addEventListener("click", () => {
    if (confirm("Are you sure you want to buy this product?")) {
        alert("Payment Successful!");
    }
});

document.getElementById("btn-add-cart").addEventListener("click", () => {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (!cart.some(p => p.id === product.id)) {
        cart.push(product);
        localStorage.setItem("cart", JSON.stringify(cart));
        alert("Product added to cart!");
    } else {
        alert("This product is already in the cart.");
    }
});
