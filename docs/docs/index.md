---
# https://vitepress.dev/reference/default-theme-home-page
layout: home
titleTemplate: false

hero:
  name: "Koverae Billing"
  text: "Subscription and billing, simplified for Laravel"
  image: /code-hero.png
  actions:
    - theme: brand
      text: Get Started
      link: /guide/introduction/index.md
    - theme: alt
      text: Star on GitHub ⭐
      link: https://github.com/Koverae/koverae-billing

featuresPerRow: 3

features:
- icon: 💳
  title: Subscription Plans with Trials and Renewals
  details: Easily define subscription plans with support for trial periods, recurring billing, upgrades, downgrades, and cancellations. Handle plan switching and trial expirations out of the box, all with simple, expressive code.
  link: /guide/subscriptions

- icon: 🔁
  title: Customizable Charge Lifecycles
  details: Track and manage charge states such as pending, paid, failed, refunded, and beyond. Define your own charge transitions and logic, giving you full control over how billing behaves in your app.
  link: /guide

- icon: 🧩
  title: Lightweight and Framework-Friendly
  details: Designed to stay out of your way. No complex configurations or magic just solid, modular billing tools that integrate cleanly into your application. Use what you need, extend what you want.
  link: /guide

- icon: ⚙️
  title: Built for Laravel
  details: "Leverages Laravel’s strengths: Eloquent, events, service container, and queues. You’ll feel right at home working with the package if you're already familiar with the Laravel ecosystem."
  link: /guide

- icon: 📊
  title: Usage-Based Billing (Coming Soon)
  details: Support for metered or usage-based billing is on the roadmap. Bill your users based on actual usage, ideal for APIs, quotas, or event-based pricing models.
  link: /roadmap

- icon: 🧠
  title: Event-Driven & Extensible
  details: Hook into key moments of the billing and subscription lifecycle. From trial starts to payment failures, use Laravel events to extend behavior or trigger custom workflows.
  link: /guide

---
