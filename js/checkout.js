// This is your test secret API key.
const stripe = Stripe("pk_test_51R3ARSLvX4xkEJEV500tRVqhjCgitunlYM00726TPB478Shiq3mAPrSR9Y9KCj3bDRLFVZXIn18eYHvNDZuLdeYn00QaOMBtN9");

initialize();

// Create a Checkout Session
async function initialize() {
  const fetchClientSecret = async () => {
    const response = await fetch("../checkout.php", {
      method: "POST",
    });
    const { clientSecret } = await response.json();
    return clientSecret;
  };

  const checkout = await stripe.initEmbeddedCheckout({
    fetchClientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}