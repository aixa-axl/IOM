# Impact One Million

WordPress theme: **ACF Flexible Content** + **Tailwind CSS** + **GitHub Actions ? WP Engine** (`iomstg`).

Pattern matches [yellow-bolts](../yellow-bolts). English first; Chinese (HK) later on the same stack.

**Figma (AXL):** https://www.figma.com/design/Qo7IPDKjiJr4NhNf02Mk93/Impact-One-Million

---

## 1. Local (Local by Flywheel)

1. Open **Local** ? Create site ? name `impact-one-million` (PHP 8.2+, latest WP).
2. Symlink or copy the theme into the site:

```bash
# From this repo
ln -sfn "$(pwd)/impact-one-million" \
  "$HOME/Local Sites/impact-one-million/app/public/wp-content/themes/impact-one-million"
```

(Adjust the Local Sites path if your folder name differs.)

3. Build assets:

```bash
cd impact-one-million
npm install
npm run watch
```

4. WP Admin ? Appearance ? Themes ? activate **Impact One Million**.
5. Install plugins:
   - **ACF Pro** (activate license under Custom Fields ? Updates)
   - Yoast SEO (optional)
   - WP Mail SMTP (when forms go live)
6. Custom Fields ? Field Groups ? **Sync** `Page Sections` if prompted.
7. Settings ? Permalinks ? Post name ? Save.

---

## 2. ACF Pro license

1. Buy/activate license at https://www.advancedcustomfields.com/
2. WP Admin ? Custom Fields ? Updates ? enter key.
3. Do **not** commit the license key or plugin zip to git (plugins stay on the server / Local).

---

## 3. WP Engine (`iomstg`)

1. Confirm staging env name: **`iomstg`** (IOM ? Stg).
2. Generate an SSH key pair for deploys (do not reuse personal keys if you prefer isolation):

```bash
ssh-keygen -t ed25519 -C "github-actions-iom" -f ~/.ssh/wpe_iom_deploy -N ""
```

3. WP Engine ? your user profile ? **SSH Keys** ? add the **public** key (`wpe_iom_deploy.pub`).
4. Wait for key propagation (often a few minutes).
5. Install ACF Pro on the WP Engine site (SFTP or WP Admin plugin upload).
6. Activate the theme after first deploy.

---

## 4. GitHub repo + Actions secrets

1. Create a private GitHub repo (e.g. `impact-one-million`).
2. Push this project to `main`.
3. Repo ? Settings ? Secrets and variables ? Actions ? New repository secret:

| Secret | Value |
|--------|--------|
| `WPE_SSHG_KEY_PRIVATE` | Full contents of `~/.ssh/wpe_iom_deploy` (private key, including `BEGIN`/`END` lines) |

4. Push to `main` (or run **Deploy to WP Engine** via Actions ? workflow_dispatch).
5. Workflow builds Tailwind and rsyncs `impact-one-million/` ? `wp-content/themes/impact-one-million/` on **`iomstg`**.

---

## 5. Figma MCP (AXL)

- Cursor MCP is already configured for Figma.
- Use the **AXL** team (Pro), not Simpatica.
- Open the Impact One Million file in Figma Desktop, select a frame, then ask Cursor to implement that section.
- Per-section workflow: Figma frame ? MCP ? `templates/layouts/{name}.php` + ACF JSON layout ? Sync in WP ? content ? check Local.

---

## 6. Day-to-day build

```bash
cd impact-one-million && npm run watch
```

1. Select a section in Figma (AXL file).
2. In Cursor: implement that section as an ACF layout (see `.cursor/rules/iom-conventions.mdc`).
3. Sync field group in WP admin; add section to a page.
4. Commit theme + `acf-json`; push to deploy staging.

---

## Chinese / Hong Kong (later)

Same theme + WPML or Polylang when ready. Optional second origin on Alibaba HK ? not required for EN launch on `iomstg`.

---

## Checklist before first staging deploy

- [ ] Local site running, theme activated
- [ ] ACF Pro licensed + Page Sections synced
- [ ] `npm run build` succeeds
- [ ] SSH public key on WP Engine
- [ ] `WPE_SSHG_KEY_PRIVATE` set in GitHub
- [ ] First push to `main` deploys to `iomstg`
- [ ] Theme visible under Appearance on staging
