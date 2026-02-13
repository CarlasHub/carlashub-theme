# CarlasHub Design Contract

## Visual Language Principles
- Mood: dark academia with mystical, editorial polish.
- Tone: quiet confidence, contemplative, ceremonial.
- Narrative: a private study at dusk; candlelight, vellum, brass, ink.
- Emotional intent: grounded warmth inside a dark, protective shell.
- Composition: centered typography, strong vertical rhythm, framed content blocks.
- Texture: subtle grain, soft gradients, and low-contrast depth (never noisy).

## Color System
All colors must map to the mandatory palette. Use tints/alpha only for state or depth.

### Semantic Roles
- `background/base`: `#0C1519`
  - Primary page background.
  - Avoid large flat black; add subtle radial gradient in the background layer.
- `background/raised`: `#162127`
  - Surfaces for cards, nav, and panels.
  - Must contrast with base by at least 1.2x luminance.
- `surface/solid`: `#3A3534`
  - Deep panel, form field background.
  - Never used for body text.
- `accent/primary`: `#724B39`
  - Buttons, separators, subtle borders.
  - Do not use for large text blocks.
- `accent/metal`: `#CF9D7B`
  - Highlights, icons, emphasis lines, small headings.
  - Must pass AA for text only when on `background/base` or `background/raised`.

### Contrast Rules
- Body text must meet WCAG AA (4.5:1) against its background.
- Script/ornamental text is display-only, not for body copy.
- Focus outlines must be at least 3:1 contrast against adjacent colors.

## Typography System
- Heading role: Cormorant Garamond (serif)
  - Tracking: +2% to +4% for H1/H2
  - Casing: title case or small caps; avoid all-caps body.
- Body role: Sora (sans)
  - Tracking: normal; avoid letter spacing.
- UI microcopy role: Sora (sans) small caps
  - Tracking: +6% to +10% for labels

### Scale and Hierarchy
- H1: 3.25rem
- H2: 2.5rem
- H3: 2rem
- H4: 1.5rem
- H5: 1.25rem
- H6: 1.1rem
- Body: 1rem
- Small: 0.875rem

## Spacing System
- Base unit: 4px
- Section spacing: 80px (desktop), 56px (tablet), 40px (mobile)
- Card padding: 28px (desktop), 20px (mobile)
- Inline spacing: 8px / 12px / 16px
- Grid: 12 columns with 24px gutters; use 6/4/3 column variants.

## Shape Language
- Corners: 6px radius for cards; 3px for inputs.
- Frames: thin 1px borders with `accent/primary` at 40% opacity.
- Lines: hairline separators (1px) and occasional 2px rules.
- Ornaments: circular sigils and radial linework as accents only.

## Motifs
- Where they appear: hero blocks, section dividers, and CTA banners.
- Where they must never appear: body copy areas, dense lists, or form fields.

## Interaction Rules
- Hover: slight lift (translateY -2px) and soft glow (accent/metal at 15%).
- Focus: 2px outline in `accent/metal` with 2px offset.
- Active: reduce glow, keep border visible.
- Reduced motion: remove translation and use opacity only.

## Stop Conditions
- No WordPress implementation here.
- No CSS or theme.json here.
- This contract governs all later design decisions.
