# Jonopriyo Bazar

An online grocery shop for Bangladesh with a customer wallet, points and prizes, a referral programme, medicine and custom orders, and electricity bill payment. Built with Laravel 12 and Livewire 3. Live at https://jonopriyobazar.com

## What it has

**Customers**
- Sign up and sign in with a phone number, password reset with an OTP code, profile and saved addresses (division, district, thana, city)
- Shop: home, categories, product pages, search, wishlist and flash sales
- Cart (also as a side cart), checkout with a coupon, and pay by cash on delivery, **wallet** or **refer balance**
- Orders: history, order details, and cancellation with a reason (before the order is packed)
- Custom orders (ask for something that is not in the shop) and medicine orders
- Electricity bill payment through the listed power companies
- **Wallet**: buy a wallet package, request a withdrawal
- **Points and prizes**: products give points when delivered; points can be exchanged for prizes
- **Referral programme**: invite friends, earn a referral balance, and spend or withdraw it. Agents, marketers and developers have their own percentages and withdrawals

**Admin panel** (`/control`)
- Roles and permissions, admins, customers and agents
- Products, categories, banners, coupons, wallet packages, flash sales, delivery statuses and cancel reasons
- Orders (change status, which also moves money and points), medicine orders, electricity bills, custom orders, wallet applications, withdrawals and prizes
- Settings, FAQ, team, about, privacy and referral-policy pages, and a sale report

## How money moves

| When | What happens |
|---|---|
| Order placed with **wallet** or **refer** balance | The total is taken at once and a purchase record is saved. Not enough balance: no order is made. |
| Order **delivered** | Points are given once (points on each product × quantity). Accounts on hold are blocked. The wallet is not charged a second time. |
| Order **cancelled** (by the customer or an admin) | The wallet or refer balance is returned and the points are taken back. |
| Coupon | A fixed amount off. It works until its last day and, if it has a limit, until it has been used on that many orders. The total never goes below zero. |

## Set up

```bash
composer install
cp .env.example .env        # set APP_URL and the DB_* values
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install && npm run build
```

Create the first admin in `php artisan tinker` (the `Admin` model, then give it a role in the admin panel).

## Tests

```bash
php artisan test
```

Tests use an in-memory SQLite database (see `phpunit.xml`), so they never touch your real data. `tests/Feature/MoneyFlowTest.php` covers coupons, checkout totals, wallet and refer payments, cancellation refunds, points and prizes.

## Notes

- Delivery charge comes from the customer's city.
- Order statuses: pending, received, packed, processing, delivered, canceled.
