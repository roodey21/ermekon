export function getInitial(fullName) {
    const words = fullName.split(' ');
    const initialsArray = words.map(word => word[0].toUpperCase());
    return initialsArray.join('');
}
