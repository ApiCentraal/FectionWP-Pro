# Release Instructions for FectionWP Pro

This document describes how to create a new release for FectionWP Pro.

## Prerequisites

- Write access to the GitHub repository
- Git configured with your GitHub credentials
- All changes committed and pushed to the main branch

## Version Numbering

FectionWP Pro follows [Semantic Versioning](https://semver.org/):
- **MAJOR.MINOR.PATCH** (e.g., 1.1.5)
- **MAJOR**: Breaking changes or major feature releases
- **MINOR**: New features, backward-compatible
- **PATCH**: Bug fixes, security patches

### Child Theme Versioning
The child theme (fectionwp-pro-tffp) should always be one patch version ahead of the parent theme:
- Parent: 1.1.5 → Child: 1.1.6
- Parent: 1.2.0 → Child: 1.2.1

## Pre-Release Checklist

1. **Update Version Numbers**
   - [ ] `style.css` - Update `Version:` field
   - [ ] `child-theme/fectionwp-pro-tffp/style.css` - Update `Version:` field (one patch ahead)
   - [ ] `package.json` - Update `version` field to match parent theme

2. **Update CHANGELOG.md**
   - [ ] Add new version section with date
   - [ ] Document all changes under appropriate categories:
     - Added (new features)
     - Changed (changes to existing functionality)
     - Deprecated (soon-to-be removed features)
     - Removed (removed features)
     - Fixed (bug fixes)
     - Security (security fixes)
   - [ ] Add comparison link at bottom

3. **Test the Theme**
   - [ ] Run PHPCS: `composer run-script phpcs`
   - [ ] Fix any issues: `composer run-script phpcbf`
   - [ ] Test in WordPress installation
   - [ ] Verify all page templates work
   - [ ] Check responsive behavior

4. **Commit Changes**
   ```bash
   git add style.css child-theme/fectionwp-pro-tffp/style.css package.json CHANGELOG.md
   git commit -m "Version bump to 1.1.5"
   git push origin main
   ```

## Creating a Release

### Step 1: Create and Push Tag

Tags must follow the format `v{version}` (e.g., `v1.1.5`):

```bash
# Create annotated tag
git tag -a v1.1.5 -m "Release version 1.1.5"

# Push tag to GitHub
git push origin v1.1.5
```

### Step 2: Automated Release Creation

Once the tag is pushed, GitHub Actions will automatically:

1. **Build the Distribution Package**
   - Create a clean zip file named `fectionwp-pro-{version}.zip`
   - The zip always contains a stable theme folder: `fectionwp-pro/` (important for child themes)
   - Exclude development files (.git, .github, node_modules, etc.)
   - Include only production-ready theme files

2. **(Optional/Recommended) Build Child Theme Package**
   - Create a zip file named `fectionwp-pro-tffp-{child-version}.zip`
   - The zip always contains a stable theme folder: `fectionwp-pro-tffp/`
   - Child version is read from `child-theme/fectionwp-pro-tffp/style.css`

3. **Create GitHub Release**
   - Generate release notes from CHANGELOG.md
   - Attach the distribution zip file (and child theme zip if present)
   - Mark as latest release

4. **Upload Release Assets**
   - The zip files will be available for download
   - Parent: `fectionwp-pro-1.1.5.zip`
   - Child (if present): `fectionwp-pro-tffp-1.1.6.zip`

### Step 3: Verify Release

1. Go to [GitHub Releases](https://github.com/ApiCentraal/FectionWP-Pro/releases)
2. Verify the new release appears with:
   - Correct version number
   - Release notes from CHANGELOG
   - Attached zip file
3. Download and test the zip file:
   ```bash
   # Extract and verify contents
   unzip fectionwp-pro-1.1.5.zip
   ls -la fectionwp-pro/
   ```

   If you also ship the child theme:
   ```bash
   unzip fectionwp-pro-tffp-1.1.6.zip
   ls -la fectionwp-pro-tffp/
   ```

## Release Workflow Details

The automated release workflow (`.github/workflows/release.yml`) performs these steps:

1. **Trigger**: On push of tags matching `v*.*.*`
2. **Build**: Creates distribution zip excluding:
   - `.git/`, `.github/`
   - `node_modules/`, `vendor/`
   - `composer.json`, `composer.lock`, `package.json`
   - `.gitignore`, `.gitattributes`
   - `test-*.php`, `*.md` (except README.md)
3. **Release**: Creates GitHub release with changelog and zip asset

## Troubleshooting

### Tag Already Exists
If you need to re-create a tag:
```bash
# Delete local tag
git tag -d v1.1.5

# Delete remote tag
git push origin :refs/tags/v1.1.5

# Create new tag
git tag -a v1.1.5 -m "Release version 1.1.5"
git push origin v1.1.5
```

### Workflow Failed
1. Check [GitHub Actions](https://github.com/ApiCentraal/FectionWP-Pro/actions)
2. Review the workflow run logs
3. Fix issues and re-create the tag
4. Common issues:
   - Missing files in repository
   - Invalid CHANGELOG.md format
   - Permission issues (check repository settings)

### Manual Release Creation
If automation fails, create a manual release:
```bash
# Create distribution zip manually
zip -r fectionwp-pro-1.1.5.zip . \
  -x "*.git*" ".github/*" "node_modules/*" "vendor/*" \
  -x "composer.*" "package*.json" ".gitignore" ".gitattributes" \
  -x "test-*.php" "*.md"

# Upload via GitHub web interface:
# 1. Go to Releases → Draft a new release
# 2. Tag: v1.1.5
# 3. Title: FectionWP Pro 1.1.5
# 4. Copy changelog content
# 5. Attach zip file
# 6. Publish release
```

## Release Cadence

- **Patch releases**: As needed for bug fixes (1-2 weeks)
- **Minor releases**: New features (monthly or as needed)
- **Major releases**: Breaking changes (quarterly or as needed)

## Post-Release Tasks

1. **Announce Release**
   - Update theme documentation site
   - Notify users via email/blog post
   - Update WordPress.org (if applicable)

2. **Monitor Issues**
   - Watch GitHub issues for bug reports
   - Test in different WordPress versions
   - Check compatibility with popular plugins

3. **Plan Next Release**
   - Update project roadmap
   - Create milestone for next version
   - Triage issues and feature requests

## Security Releases

For security patches:
1. Create a security advisory on GitHub
2. Follow standard release process
3. Mark release as "security update"
4. Notify users immediately
5. Consider backporting to older versions if needed

## Support

For questions or issues with the release process:
- Open an issue on GitHub
- Contact: support@fectionlabs.com
- Documentation: https://fectionlabs.com/docs/fectionwp-pro
