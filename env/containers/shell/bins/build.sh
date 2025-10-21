mkdir -p dist
for d in niveau*; do
	pushd $d
	make
	popd
	cp $d/$d dist/
done
