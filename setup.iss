[Setup]
AppName=QLThietBi
AppVersion=1.0
DefaultDirName={autopf}\QLThietBi
DefaultGroupName=QLThietBi
OutputBaseFilename=QLThietBi_Setup
Compression=lzma2
SolidCompression=yes

[Files]
Source: "C:\xampp\htdocs\qlthietbi\*"; DestDir: "{app}"; Flags: recursesubdirs createallsubdirs

[Icons]
Name: "{group}\QLThietBi"; Filename: "{app}\Start.bat"
Name: "{commondesktop}\QLThietBi"; Filename: "{app}\Start.bat"
