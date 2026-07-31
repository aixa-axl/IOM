# Impact One Million

Custom WordPress theme ? ACF Flexible Content, Tailwind CSS, GitHub Actions ? WP Engine (`iomstg`).

## Quick start

See **[SETUP.md](./SETUP.md)** for Local, ACF Pro, WP Engine SSH, and GitHub secrets.

```bash
cd impact-one-million
npm install
npm run watch
```

## Structure

```
impact-one-million/          ? WordPress theme (deployed)
??? acf-json/                ? ACF field groups (versioned)
??? assets/css|js|images/
??? src/input.css            ? Tailwind source
??? templates/layouts/       ? ACF flexible content partials
??? functions.php
??? page.php
??? .deployignore
.github/workflows/deploy.yml
.cursor/rules/iom-conventions.mdc
```

## Deploy

Push to `main` ? builds CSS ? deploys theme to WP Engine environment **`iomstg`**.

Secret required: `WPE_SSHG_KEY_PRIVATE`

## Figma

AXL team file: https://www.figma.com/design/Qo7IPDKjiJr4NhNf02Mk93/Impact-One-Million
