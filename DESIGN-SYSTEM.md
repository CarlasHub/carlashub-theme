# CarlasHub V2 Design System

## 1. Visual concept summary

CarlasHub V2 is a classic WordPress theme that reinterprets the experience of a GitHub profile and repository environment into an original, dark-first publishing system. It does not clone GitHub. It adapts GitHub's product logic:

- compact global navigation
- identity-first page entry
- tab-like section cueing
- pinned-content emphasis
- metadata-rich listings
- documentation-grade reading pages
- side-panel information rails
- discussion-thread treatment for comments

The theme is designed to feel structured, technical, calm, and premium. Every default WordPress page type is mapped to a concrete GitHub-like interaction pattern rather than merely reskinned with a dark palette.

## 2. Core design language

- Global shell: restrained width, dense but readable content, no oversized hero gimmicks
- Surface model: one deep canvas, layered panels, subtle borders, controlled elevation
- Interaction model: clear current states, visible focus, compact navigation, low-noise controls
- Information model: path labels, badges, stats, facts rails, archive counts, metadata side panels
- Accessibility model: semantic HTML first, labelled forms, keyboard-safe navigation, reduced motion support

## 3. Colour tokens

These tokens are the actual values used in `style.css`.

- `--canvas`: `#0d1117`
- `--canvas-alt`: `#111827`
- `--surface`: `#141c28`
- `--surface-alt`: `#1a2331`
- `--surface-strong`: `#202b3b`
- `--surface-code`: `#0d1522`
- `--surface-footer`: `#0f1622`
- `--border`: `#2b3544`
- `--border-strong`: `#394559`
- `--text`: `#edf3ff`
- `--text-soft`: `#cad5e8`
- `--text-muted`: `#92a1bb`
- `--accent`: `#5f90ff`
- `--accent-strong`: `#86adff`
- `--accent-alt`: `#55d2c0`
- `--success`: `#3ccf91`
- `--warning`: `#ffbd59`
- `--error`: `#ff7676`
- `--info`: `#61b5ff`
- `--code-a`: `#8bd5ff`
- `--code-b`: `#ffd479`

## 4. Typography scale

- Body copy: `1rem / 1.7`
- Small UI metadata: `0.78rem` to `0.92rem`
- Card title: `1.3rem`
- Section heading: `1.7rem` to `2.35rem`
- Hero heading: `2.35rem` to `4rem`
- Sans stack: `Inter`, `"Segoe UI"`, `-apple-system`, `BlinkMacSystemFont`, `"Helvetica Neue"`, `sans-serif`
- Mono stack: `"SFMono-Regular"`, `Consolas`, `"Liberation Mono"`, `Menlo`, `monospace`

## 5. Spacing scale

- `--space-1`: `0.375rem`
- `--space-2`: `0.625rem`
- `--space-3`: `0.875rem`
- `--space-4`: `1.125rem`
- `--space-5`: `1.5rem`
- `--space-6`: `2rem`
- `--space-7`: `3rem`
- `--space-8`: `4rem`

Spacing is applied systematically:

- `--space-5` for internal panel rhythm
- `--space-6` for larger panel padding
- `--space-7` for section separation
- `--space-8` only for major vertical breaks

## 6. Layout rules

- Primary shell: `76rem`
- Wide shell: `88rem`
- Reading column target: `46rem`
- Header: compact sticky bar with brand block, nav, and integrated search
- Homepage hero: two-column identity/status split on desktop, single column on mobile
- Featured area: two-up card grid on larger screens
- Listings: stacked repository-style rows with a main content area and a facts rail
- Documents: content column plus metadata/sidebar column

## 7. Component inventory

- Header with compact nav, mobile menu toggle, brand block, and search
- Footer with four grouped sections and utility row
- Profile hero and status panels
- Section tabs with bottom-border current/hover behavior
- Featured cards and listing rows
- Topic cards
- Metadata pills and badges
- Taxonomy chips
- Sidebar panels and widgets
- Search forms
- Comment thread panels
- Pagination
- Post navigation
- Tables, code blocks, blockquotes, notices
- Empty states and route-recovery states

## 8. Homepage structure

The front page is intentionally mapped to a GitHub profile-like landing surface:

1. Compact sticky header
2. Identity-led hero with monogram/logo, title, summary, actions, and top-level metrics
3. Status panel that behaves like profile metadata
4. Tab-like anchor navigation
5. Pinned writing grid
6. Topic directory grid
7. Recent activity stream
8. Navigation band
9. Structured footer

## 9. Explicit page-type mapping

### Front page

- Role: site entry and primary identity surface
- GitHub concept being adapted: profile header logic, pinned repository cards, tabbed section cueing
- Layout pattern: hero plus side status panel, tab row, pinned grid, topic directories, recent activity stream, practical closing band
- Component pattern: hero identity block, metadata pills, status list, featured cards with thumbnail media when available (featured image first, then first inline image), topic cards, timeline items with optional thumbnails when media exists
- Styling logic: strongest identity treatment in the theme, compact but confident spacing, layered panels, path labels, badges, and activity signals

### Blog index

- Role: primary journal and article listing
- GitHub concept being adapted: repository listing logic with pinned repositories surfaced above the list
- Layout pattern: archive header, optional pinned row, structured listing rows, sidebar rail
- Component pattern: metrics pills, featured cards for sticky posts, listing rows with facts rail, pagination
- Styling logic: denser than the homepage, more operational and index-like, less hero emphasis and more metadata clarity

### Page

- Role: static documentation or product information page
- GitHub concept being adapted: documentation reading flow with metadata side panel
- Layout pattern: document header, reading column, metadata/sidebar rail
- Component pattern: path label, page summary, route metadata card, stacked sidebar panels
- Styling logic: quieter than the front page, narrower and more readable, with documentation-style emphasis over promotional styling

### Single post

- Role: technical reading page for an article
- GitHub concept being adapted: documentation reading flow plus repository metadata rail plus discussion-thread attachment
- Layout pattern: document header, reading column, metadata/contributor rail, post navigation, comments thread below
- Component pattern: path label, taxonomy chips, author metadata, contributor box, stable permalink, post navigation, comments
- Styling logic: highest readability priority, strongest prose and code treatment, metadata presented as structured side information rather than decorative ornaments

### Archive

- Role: generic filtered content index
- GitHub concept being adapted: repository/resource listing page
- Layout pattern: archive header with count, listing rows, sidebar rail
- Component pattern: results pill, listing rows, pagination, metadata sidebar
- Styling logic: systematic and restrained, focused on scanability and count visibility

### Category

- Role: topic-specific archive
- GitHub concept being adapted: repository topic grouping / filtered index
- Layout pattern: topic header with description and count, listing rows, sidebar
- Component pattern: topic count pill, listing rows, category-driven sidebar discovery
- Styling logic: same base archive system, but with stronger topic framing so it feels like a maintained content directory

### Tag

- Role: cross-cutting label archive
- GitHub concept being adapted: lightweight label/tag filter view
- Layout pattern: tag header with count, listing rows, sidebar
- Component pattern: tagged-post count pill, listing rows, pagination
- Styling logic: same listing system as archives, but framed as a looser label-based cross-reference rather than a curated topic directory

### Author

- Role: contributor archive
- GitHub concept being adapted: profile/contributor surface plus repository listing
- Layout pattern: author header, contributor card, listing rows, sidebar
- Component pattern: author count pill, contributor box, listing rows, archive metadata
- Styling logic: blends profile identity cues with listing logic so the page feels like a contributor home rather than a generic author archive

### Search results

- Role: query-based discovery page
- GitHub concept being adapted: search results index / repository search listing
- Layout pattern: results header with count, listing rows, sidebar
- Component pattern: match count pill, listing rows, pagination
- Styling logic: operational and scan-heavy, focused on quick result comprehension and consistent structure

### No results

- Role: empty search or empty filter recovery state
- GitHub concept being adapted: empty repository/filter/search state
- Layout pattern: centered empty-state panel with guidance and immediate recovery control
- Component pattern: clear message, explanatory copy, search form
- Styling logic: same panel language as the rest of the system, but simplified and recovery-oriented rather than decorative

### 404

- Role: route recovery page
- GitHub concept being adapted: missing route or missing resource state
- Layout pattern: centered recovery panel with action buttons and search
- Component pattern: branded heading, recovery actions, labelled search form
- Styling logic: deliberate and restrained, not jokey, preserving platform tone while helping the user recover quickly

### Comments

- Role: discussion attached to a document
- GitHub concept being adapted: discussion-thread feel from issues/discussions
- Layout pattern: discussion intro panel, threaded comment list, reply form panel
- Component pattern: avatars, author metadata, reply links, moderation note, nested threads
- Styling logic: comments are integrated into the document system with panel styling and clear thread structure instead of being visually detached

### Sidebar / widgets

- Role: metadata rail and discovery support
- GitHub concept being adapted: repository metadata side panels
- Layout pattern: stacked compact panels
- Component pattern: single-post share panel, recent updates, topics, archives, and styled default widgets
- Styling logic: compact, low-noise, utility-first panels with consistent borders, typography, and row treatment

### Footer

- Role: low-noise global utility and site-map zone
- GitHub concept being adapted: platform footer / project hub bottom rail
- Layout pattern: four grouped sections plus a utility strip
- Component pattern: site summary, navigation links, top topics, recent updates, bottom utility links
- Styling logic: visually integrated with the site shell, subdued but readable, avoiding the disconnected feel of a generic WordPress footer

## 10. Implementation alignment notes

The theme files follow the mapping above directly:

- `front-page.php` implements profile header logic, pinned cards, tabs, topic directories, and update stream
- `home.php` implements pinned-plus-listing repository logic for the main journal
- `page.php` and `single.php` implement documentation reading flow with metadata side panels
- `archive.php`, `category.php`, `tag.php`, `author.php`, and `search.php` implement filtered listing logic with counts
- `comments.php` implements the discussion-thread layer
- `sidebar.php` implements the metadata rail
- `footer.php` implements the grouped platform footer
- `functions.php` centralizes the shared card, path-label, pinned-post, and fallback-navigation logic so the mapping stays consistent across templates

## 11. Visual dos and don’ts

### Do

- Keep borders subtle and spacing disciplined
- Use path labels, badges, counts, and facts rails consistently
- Make headers compact and structured
- Preserve strong contrast and visible focus
- Keep archive and search pages as first-class product surfaces

### Don’t

- Do not turn the front page into a brochure hero
- Do not let listing pages collapse into generic blog cards
- Do not use oversized rounded navigation pills
- Do not let widgets fall back to visibly default WordPress styling
- Do not make footer sections feel detached from the main shell
