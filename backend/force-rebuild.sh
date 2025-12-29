#!/bin/bash
# Script to force a fresh Railway build without cache

echo "🔄 Forcing fresh Railway build..."

# Update CACHE_BUST in Dockerfile
CURRENT_VALUE=$(grep -oP 'ARG CACHE_BUST=\K\d+' Dockerfile 2>/dev/null || echo "1")
NEW_VALUE=$((CURRENT_VALUE + 1))

echo "📝 Updating CACHE_BUST from $CURRENT_VALUE to $NEW_VALUE"

# Update Dockerfile (works on both Linux and macOS)
if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    sed -i '' "s/ARG CACHE_BUST=[0-9]*/ARG CACHE_BUST=$NEW_VALUE/" Dockerfile
else
    # Linux
    sed -i "s/ARG CACHE_BUST=[0-9]*/ARG CACHE_BUST=$NEW_VALUE/" Dockerfile
fi

# Add timestamp to BUILD_DATE
TIMESTAMP=$(date -u +"%Y-%m-%dT%H:%M:%SZ")
if [[ "$OSTYPE" == "darwin"* ]]; then
    sed -i '' "s/ARG BUILD_DATE=.*/ARG BUILD_DATE=$TIMESTAMP/" Dockerfile
else
    sed -i "s/ARG BUILD_DATE=.*/ARG BUILD_DATE=$TIMESTAMP/" Dockerfile
fi

echo "✅ Dockerfile updated"
echo ""
echo "📤 Committing and pushing changes..."

# Commit and push
git add Dockerfile
git commit -m "Force rebuild: cache-bust to $NEW_VALUE ($TIMESTAMP)"
git push

echo ""
echo "✅ Changes pushed! Railway will now build fresh without cache."
echo ""
echo "📊 Monitor the build:"
echo "   railway logs --deployment"
echo ""
echo "🔍 Verify extensions after build:"
echo "   railway run php -m | grep pgsql"

