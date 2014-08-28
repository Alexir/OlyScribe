### get the list of utterances to transcribe
# Assumes standard log folder structure: yyymmdd/sss/<logged_data>
# [20120505] (air) Started
#


# set the day and session of interest...
$day=$ARGV[0];
$set=$ARGV[1];

opendir(IN,"../$day/$set") || die ("no dir...\n");
@wav = grep { /\d{3}\.wav$/ } readdir(IN);
foreach $f (@wav) {
    print "../$date/$set/$f\n";
}
#
